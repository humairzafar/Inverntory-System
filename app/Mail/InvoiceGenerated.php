<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf; // Make sure you installed barryvdh/laravel-dompdf

class InvoiceGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Define the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your Invoice - Order #' . $this->order->id,
        );
    }

    /**
     * Define the content (email body).
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.invoice', // This is the Blade template
            with: ['order' => $this->order], // Pass order to view
        );
    }

    /**
     * Attach the PDF invoice.
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('payment.invoice', ['order' => $this->order])->output();

        return [
            \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdf, 'invoice_order_' . $this->order->id . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
