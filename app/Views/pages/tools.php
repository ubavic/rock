<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
    <h1>Aлати</h1>
    <p>Ово су алати намењени побољшавању кодова задатака. Опис сваког алата се налази на крају ове странице.</p>
    <div class="formRow">
        <textarea width="100%" id="code" rows="10"></textarea>
    </div>
    <div class="formRow">
        <button type="button" onclick="transliterate()" class="button smallButton">Конвертуј у ћирилицу</button>
        <button type="button" onclick="interpunction()" class="button smallButton">Побољшај интерпункцију</button>
        <div style="margin-left:auto;"></div>
        <button type="button" onclick="updateResult()" class="button smallButton">Прегледај</button>
    </div>
    <div id="result" class="problemEntry">
    </div>
    <hr>
    <ul>
        <li><b>Конвертуј у ћирилицу</b> - конвертује латинични текст у ћирилицу. Диграфи <em>lj, nj, dž</em> се конвертују у одговарајућа ћирилична слова <em>љ,њ,џ</em> (тако реч <em>konjunkcija</em> постаје <em>коњункција</em> што је неисправно!). <em>LaTex</em> и <em>HTML</em> остају неизмењени.</li>
        <li><b>Побољшај интерпункцију</b> - уводи тачку и зарез унутар <em>LaTex</em> тагова, ако су се ти знаци налазили непосредно након тих тагова. Ово спречава погрешан прелом који се јавља с <em>KaTex</em> додатком. Овај алат такође уклања сувишне размаке.</li>
    </ul>
    <script src="./js/pasukon.dist.min.js"></script>
    <script src="./js/grammar.js"></script>
    <script src="./js/tools.js"></script>
    <script>window.onload = setup();</script>
<?= $this->endSection(); ?>