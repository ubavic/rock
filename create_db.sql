
START TRANSACTION;

CREATE TABLE `subjects` (
 `id`   int UNSIGNED NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `code` varchar(10) NOT NULL,

 PRIMARY KEY (`id`)
);


CREATE TABLE `users` (
 `id`               int UNSIGNED NOT NULL AUTO_INCREMENT,
 `name`             varchar(255) NOT NULL,
 `email`            varchar(255) NOT NULL,
 `hash`             varchar(255) NOT NULL,
 `status`           tinyint NOT NULL,
 `created_at`       timestamp NOT NULL DEFAULT current_timestamp(),
 `updated_at`       timestamp NOT NULL DEFAULT current_timestamp(),
 `deleted_at`       timestamp NULL DEFAULT NULL,
 `can_add`          tinyint UNSIGNED NOT NULL DEFAULT 1,
 `can_delete`       tinyint UNSIGNED NOT NULL DEFAULT 0,
 `can_edit`         tinyint UNSIGNED NOT NULL DEFAULT 0,
 `can_manage_users` tinyint UNSIGNED NOT NULL DEFAULT 0,
 `ver_code`         int UNSIGNED NULL DEFAULT NULL,

 PRIMARY KEY (`id`)
);


CREATE TABLE `exams` (
 `id`              int UNSIGNED NOT NULL AUTO_INCREMENT,
 `subject`         int UNSIGNED NOT NULL,
 `type`            tinyint NOT NULL,
 `date`            date NOT NULL,
 `duration`        int NOT NULL,
 `note`            text NULL,
 `created_at`      timestamp NOT NULL DEFAULT current_timestamp(),
 `updated_at`      timestamp NOT NULL DEFAULT current_timestamp(),
 `deleted_at`      timestamp NULL,
 `created_by`      int UNSIGNED NOT NULL,
 `updated_by`      int UNSIGNED NOT NULL,
 `ma`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `mi`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `ml`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `mm`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `mp`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `mr`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `ms`              tinyint UNSIGNED NOT NULL DEFAULT 0,
 `edit_lock`       int UNSIGNED DEFAULT NULL,

 PRIMARY KEY (`id`),
 FOREIGN KEY (`subject`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
 FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
 FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
 FOREIGN KEY (`edit_lock`) REFERENCES `users` (`id`) ON DELETE SET NULL
);


CREATE TABLE `problems` (
 `id`     int UNSIGNED NOT NULL AUTO_INCREMENT,
 `exam`   int UNSIGNED NOT NULL,
 `text`   text NOT NULL,
 `points` tinyint UNSIGNED zerofill NOT NULL,

 PRIMARY KEY (`id`),
 FOREIGN KEY (`exam`) REFERENCES `exams` (`id`) ON DELETE CASCADE
);


CREATE TABLE `saved_exams` (
 `id`   int UNSIGNED NOT NULL AUTO_INCREMENT,
 `user` int UNSIGNED NOT NULL,
 `exam` int UNSIGNED NOT NULL,
 `save_time` timestamp NOT NULL DEFAULT current_timestamp(),

 PRIMARY KEY (`id`),
 FOREIGN KEY (`exam`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
 FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE
);


CREATE TABLE `login_log` (
 `id`   int UNSIGNED NOT NULL AUTO_INCREMENT,
 `user` int UNSIGNED NULL,
 `time` timestamp NOT NULL DEFAULT current_timestamp(),
 `ip`   varchar(45) NOT NULL,

 PRIMARY KEY (`id`),
 FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE
);


INSERT INTO `subjects` (`id`, `name`, `code`) VALUES
(1, 'Линеарна алгебра', 'М1.01'),
(2, 'Увод у математичку логику', 'М1.02'),
(3, 'Алгебра 1', 'М1.04'),
(4, 'Дискретна математика', 'М1.05'),
(5, 'Алгебра 2', 'М1.06'),
(6, 'Методика наставе математике А', 'М1.07'),
(7, 'Теорија бројева 1', 'М1.08'),
(8, 'Историја и филозофија математике', 'М1.09'),
(9, 'Теорија алгоритама', 'М1.10'),
(10, 'Одабрана поглавља алгебре и математичке логике', 'М1.12'),
(11, 'Алгебра 3', 'М1.13'),
(12, 'Методика наставе математике и рачунарства', 'М1.14'),
(13, 'Елементарна теорија бројева', 'М1.16'),
(14, 'Математичка логика у рачунарству', 'М1.17'),
(15, 'Анализа 1', 'М2.01'),
(16, 'Анализа 2', 'М2.03'),
(17, 'Увод у комплексну анализу', 'М2.05'),
(18, 'Диференцијалне једначине А', 'М2.06'),
(19, 'Теорија мере и интеграције', 'М2.07'),
(20, 'Диференцијалне једначине Б', 'М2.08'),
(21, 'Методика наставе математике Б', 'М2.09'),
(22, 'Увод у теоријску механику', 'М2.10'),
(23, 'Анализа 3А', 'М2.12'),
(24, 'Комплексна анализа А', 'М2.13'),
(25, 'Анализа 3Б', 'М2.14'),
(26, 'Комплексна анализа Б', 'М2.15'),
(27, 'Дистрибуције и парцијалне једначине А', 'М2.16'),
(28, 'Дистрибуције и парцијалне једначине Б', 'М2.17'),
(29, 'Увод у теорију динамичких система', 'М2.20'),
(30, 'Математичке методе квантне механике', 'М2.21'),
(31, 'Диференцијалне једначине', 'М2.23'),
(32, 'Функционална анализа', 'М2.24'),
(33, 'Једначине математичке физике', 'М2.27'),
(34, 'Комплексне функције', 'М2.31'),
(35, 'Геометрија 1', 'М3.01'),
(36, 'Геометрија 2', 'М3.02'),
(37, 'Геометрија 3', 'М3.03'),
(38, 'Геометрија 4', 'М3.04'),
(39, 'Методика наставе математике Ц', 'М3.05'),
(40, 'Геометрија 5', 'М3.07'),
(41, 'Диференцијална геометрија', 'М3.08'),
(42, 'Увод у нумеричку математику', 'М4.01'),
(43, 'Образовни софтвер', 'М4.03'),
(44, 'Нумеричке методе', 'М4.04'),
(45, 'Нумеричка анализа 1А', 'М4.07'),
(46, 'Увод у теорију екстремалних проблема', 'М4.08'),
(47, 'Нумеричка анализа 1Б', 'М4.09'),
(48, 'Основе математичког моделирања', 'М4.12'),
(49, 'Нумеричка анализа 2А', 'М4.13'),
(50, 'Методе математичког програмирања', 'М4.14'),
(51, 'Нумеричка анализа 2Б', 'М4.15'),
(52, 'Варијациони рачун', 'М4.16'),
(53, 'Конвексна анализа', 'М4.18'),
(54, 'Вероватноћа и статистика А', 'М5.01'),
(55, 'Вероватноћа и статистика Б', 'М5.02'),
(56, 'Теорија вероватноћа', 'М5.03'),
(57, 'Статистички софтвер 1', 'М5.04'),
(58, 'Математичка статистика', 'М5.05'),
(59, 'Случајни процеси', 'М5.06'),
(60, 'Статистички софтвер 2', 'М5.07'),
(61, 'Теорија узорака', 'М5.08'),
(62, 'Статистички софтвер 3', 'М5.09'),
(63, 'Елементи актуарске математике', 'М5.10'),
(64, 'Временске серије и примене у финансијама', 'М5.11'),
(65, 'Статистички софтвер 4', 'М5.12'),
(66, 'Елементи финансијске математике', 'М5.19'),
(67, 'Топологија А', 'М6.02'),
(68, 'Топологија Б', 'М6.03'),
(69, 'Алгебарска топологија', 'М6.04'),
(70, 'Програмирање 1', 'РМ01'),
(71, 'Програмирање 2', 'РМ02'),
(72, 'Увод у организацију и архитектуру рачунара 1', 'РМ03'),
(73, 'Објектно-оријентисано програмирање', 'РМ04'),
(74, 'Методика наставе рачунарства А', 'РМ05'),
(75, 'Методика наставе рачунарства Б', 'РМ06'),
(76, 'Дизајн програмских језика', 'РМ08'),
(77, 'Конструкција и анализа алгоритама', 'РМ09'),
(78, 'Лексичка анализа и примене', 'РМ10'),
(79, 'Компилација програмских језика', 'РМ11'),
(80, 'Програмске парадигме', 'РМ12'),
(81, 'Увод у релационе базе података', 'РМ13'),
(82, 'Оперативни системи', 'РМ14'),
(83, 'Архитектура рачунара 1', 'РМ15'),
(84, 'Програмирање база података', 'РМ16'),
(85, 'Рачунарске мреже', 'РМ17'),
(86, 'Увод у вероватноћу', 'МС5.01'),
(87, 'Увод у финансијску математику', 'С1.01');

COMMIT;