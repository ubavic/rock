<img src="asset/repository-image.png" alt="МАТФ РОКОВИ" title="Matf rokovi">

Ovo je kôd sajta [MATF Rokovi](https://rokovi.ubavic.rs/). Sajt je napisan u PHP jeziku uz pomoć [CodeIgniter](https://github.com/codeigniter4/CodeIgniter4) framework-a.

Svaka pomoć u razvoju softvera je dobrodošla.

## Instalacija

Za pokretanje ovog softvera potreban je server sa PHP jezikom verzije barem 7.2 i MySQL bazom verzije barem 5.1. 

Sledeće PHP ekstenzije moraju biti instalirane/omogućene `intl`, `mbstring`, `php-json` , `php-mysqlnd` , `php-xml`. 

Prilikom instalacije potrebno je kreirati jednu bazu, a zatim pomoću skripte `database_creation_script.sql`, kreirati tabele unutar ove baze. Zatim je potrebno podesiti odgovarajuće parametre (ime baze, kredencijale) unutar fajla `.env` koji se kreira kopiranjem fajla `env`.
