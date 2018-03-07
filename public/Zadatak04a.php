<?php
//ulazni parametri

$countries = array(
	array(
		"code" => "rs",
		"name" => "Serbia",
		"capital" => "Belgrade",
		"currency" => "RSD",
		"government" => "republic"
	),
	array(
		"code" => "ru",
		"name" => "Russia",
		"capital" => "Moscow",
		"currency" => "RUB",
		"government" => "federation"
	),
	array(
		"code" => "it",
		"name" => "Italy",
		"capital" => "Rome",
		"currency" => "EUR",
		"government" => "republic"
	),
	array(
		"code" => "es",
		"name" => "Spain",
		"capital" => "Madrid",
		"currency" => "EUR",
		"government" => "kingdom"
	),
	array(
		"code" => "uk",
		"name" => "United Kingdom",
		"capital" => "London",
		"currency" => "GBP",
		"government" => "kingdom"
	)
);

$searchGovernments = array("republic", "federation");

//ulazni parametri


/*


Zadatak

Na ekranu treba da se prikazu samo zemlje koje koje imaju kljuc "government" jednak jednoj od vrednosti u nizu u promenljivoj $searchGovernments.
Dakle ulazni parametar $searchGovernments je kriterijum pretrage koji definise dozvoljena drzavna uredjenja tj dozvoljene vrednosti za kljuc 'government'.


Tako da ako su u promenljivoj $searchGovernments date dozvoljena drzavna uredjenja 'federation' i 'republic' onda treba da se ispise tekst:



The capital of Serbia is Belgrade, the short code is (rs), and official currency is RSD
The capital of Russia is Moscow, the short code is (ru), and official currency is RUB
The capital of Italy is Rome, the short code is (it), and official currency is EUR



Tj treba da se ispisu samo zemlje koje imaju 'government' jednak 'federation' ili 'republic'.
Hint: in_array

*/
foreach ($countries as $key => $value) {
if(in_array($searchGovernments[0], $value) || in_array($searchGovernments[1], $value) ){
    echo $value['name'];                  

}
 
		

}

