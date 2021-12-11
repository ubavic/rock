% !TEX TS-program = xelatex
% !TEX encoding = UTF-8 Unicode
% kompajlirati sa xetex sa kompajlerom!

\documentclass[11pt]{article}
\usepackage{fontspec}
\setmainfont{DejaVu Serif} % Postaviti font
\usepackage{amsmath}
\usepackage{amssymb}
\usepackage{amsthm}
\theoremstyle{definition}
\newtheorem{zadatak}{Задатак}

\begin{document}

\flushright <?= $exam->date_string ?>


\begin{center}
<?php if ($exam->type == 0): ?>
Писмени испит из предмета
<?php else: ?>
Колоквијум из предмета
<?php endif; ?>

\Large{<?= $exam->subject_name ?>}

<?php if($exam->modules_string): ?>
<?php if(strlen($exam->modules_string) > 2): ?>
За смерове <?= $exam->modules_string ?>.
<?php else: ?>
За смер <?= $exam->modules_string ?>.
<?php endif; ?>
<?php endif; ?>

\end{center}

\medskip

<?php if ($exam->note != null): ?>
<?= $exam->note ?>

\medskip
<?php endif; ?>

<?= $problems ?>

\end{document}
