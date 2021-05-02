<?= $this->extend('page'); ?>
<?= $this->section('content'); ?>
    <h1>Упутство за додавање и измену рокова</h1>
    <p>Право додавања нових рокова имају сви регистровани чланови. Право измене рокова имају само чланови који су добили одговарајућу дозволу за то. Рок измењујемо тако што одемо на страницу рока ког желимо да изменимо, а затим кликнемо на дугме <i>Измени рок</i> које се налази на дну странице.</p>
    <p>Форме за додавање и измену рокова су идентичне. У наставку ће бити објашњено свако од поља доступно у формама:</p>
    <ul>
        <li><b>Предмет</b> - уз помоћ овог падајућег менија бира се предмет рока. Ако не постоји предмет за који додајете рок, обратите се администратору сајта.</li>
        <li><b>Датум</b> - поље за унос датума. Датум се уноси у облику <code>mm/dd/yyyy</code>.</li>
        <li><b>Колоквијум</b> - поље које треба означити ако се уноси колоквијум.</li>
        <li><b>Трајање</b> - у ово поље се уноси предвиђено трајање испита у минутима. Ако ова информација није позната, оставити празно поље или 0.</li>
        <li><b>Модул/Смер</b> - поља која се користе за означавање модула/смерова за које је рок намењен. Модули односно смерови су наведени у скраћеном облику; преласком курсора миша преко њихове ознаке добија се пун назив.</li>
        <li><b>Текст</b> - у ово поље се наводе све информације које су наведене на папиру рока, а нису могле бити унете помоћу осталих поља.</li>
        <li><b>Додај задатак</b> - притиском на ово дугме отвара се нова форма уз помоћ које је могуће унети текст задатка. У поље за унос задатка је потребно унети текст задатка на ћирилици (алат за конвертовање латинице у ћирилицу је доступан на страници <a href="/tools">Алати</a>). Текст је могуће форматирати уз помоћ <i>html</i> кодова попут <code>&lt;p&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;b&gt;</code>, <code>&lt;ol&gt;</code>, <code>&lt;ul&gt;</code>, итд&hellip;</li>
        <li><b>Прегледај</b> - притиском на ово дугме се задатак прегледа. Задатак се поново може изменити притиском на дугме <b>Измени</b>.</li>
        <li><b>Обриши</b> - притиском на ово дугме задатак се брише. Ово дугме није доступно приликом измене задатака. За брисање већ унетих задатака обратите се администратору сајта.</li>
        <li><b>Поена</b> - у ово поље су уноси број поена које доноси задатак. Ако ова информација није позната, оставити празно поље или 0. У случају да се задатак састоји од више делова, потребно је унети само укупан број поена које доноси задатак.</li>
        <li><b>Унеси</b> - притиском на ово дугме задатак се уноси у базу.</li>
    </ul>
    <h3><i>LaTex</i></h3>
    <p>На овом сајту се користи <a href="https://katex.org/"><i>Katex</i></a> библиотека за приказивање математичких формула. Уз помоћ ње се математички изрази написани у <i>LaTex</i>-у приказују на свим модерним прегледачима.</p>
    <p><i>LaTex</i> изразе је могуће писати у свим текстуалним пољима. Изрази се пишу тако што се <i>LaTex</i> кодови наводе између <code>\( \)</code>, односно <code>\[ \]</code>, тагова који одговарају редом <i>inline</i> и <i>display</i> стиловима.</p>
    <p>Разлике између <i>KaTeX</i>-а и стандардног <i>LaTeX</i>-а су минималне: битно је само користити команде <code>\lt</code> и <code>\gt</code> уместо знакова <code>&lt;</code> и <code>&gt;</code> (ово је неопходно јер су знакови <code>&lt;</code> и <code>&gt;</code> део <i>HTML</i> тагова). </p>
    <p>Списак подржаних команди се може пронаћи на страници <a href="https://katex.org/docs/supported.html"><i>Supported Functions</i></a>.</p>
    <hr>
    <p>За сва додатна питања, обратите се администратору сајта.</p>
<?= $this->endSection(); ?>