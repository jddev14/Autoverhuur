@component('mail::message')
# Introduction

Hello {{$user->voornaam}},
Thanks for renting a car at our company.

here is a confirmation of your purchase.
@component('mail::table')
| Auto's                         | datum ingehuurd                        | Inlever datum                         | Prijs     |
| :------------------------------| :--------------------------------------| :-------------------------------------| ---------:|
| {{$auto->auto_grootte}}        | {{$huurovereenkomst->datum_ingehuurd}} |{{$huurovereenkomst->datum_inlevering}}|Fls 100,00 |

|  total    |
| ---------:|
|Fls 100,00 |
@endcomponent

@component('mail::button', ['url' => ''])
Autoverhuur 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

