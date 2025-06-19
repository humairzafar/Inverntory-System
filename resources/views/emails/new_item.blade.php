@component('mail::message')
# A New Item Has Been Added!

**Name:** {{ $item->name }}  
**Amount:** {{ $item->amount }}  
**Brand:** {{ $item->brand->name ?? '-' }}  
**Model:** {{ $item->model->name ?? '-' }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
