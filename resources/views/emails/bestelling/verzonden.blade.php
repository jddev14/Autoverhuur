@component('mail::message')
# Hallo {{$user->voornaam}},

Bedankt om ons bedrijf te kiezen voor het huren van auto's.
Voor ons is het een voorrecht.

Hier is u bevestiging van de Huurovereenkomst.
@component('mail::table')

<?php
if(isset($autosdet)){
$columns = ['Auto (\'s)','datum ingehuurd','Inlever datum','Prijs'];
$rows = array();
$arraysize=sizeof($autosdet);
for($i = 0; $i < $arraysize;$i++){
$singleauto = [$autosdet[$i]->auto_grootte.' passagiers',$huurovereenkomst->datum_ingehuurd, $huurovereenkomst->datum_inlevering, 'fls '.$autosdet[$i]->prijs.',--'];

    array_push($rows,$singleauto);

}

$t = new App\Mail\TextTable($columns,$rows);

$t->setAlgin(['L', 'C', 'C', 'R']);
echo \PHP_EOL;
echo $t->render();

$columns2 = ['Totaal','fls '.$huurovereenkomst->totaal_bedrag.',--'];
$rows2 = array();
$t2 = new App\Mail\TextTable($columns2,$rows2);

$t2->setAlgin(['R', 'R']);
echo \PHP_EOL;
echo $t2->render();
}
?>
@endcomponent

@component('mail::button', ['url' => ''])
Autoverhuur 
@endcomponent

Groet,<br>
{{ config('app.name') }}
@endcomponent

