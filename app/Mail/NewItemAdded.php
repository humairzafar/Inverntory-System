<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewItemAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    // Add this method to specify the "from" address:
    public function sender()
    {
        return ['no-reply@yourdomain.com' => 'Your App Name'];
    }

    public function envelope()
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address('no-reply@yourdomain.com', 'Your App Name'),
            subject: 'New Item Added',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.new_item',
        );
    }

    public function attachments()
    {
        return [];
    }
}
