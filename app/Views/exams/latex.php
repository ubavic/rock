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

\flushright <?= $exam->date ?>


\begin{center}
<?php if ($exam->type == 0): ?>
Писмени испит из предмета
<?php else: ?>
Колоквијум из предмета
<?php endif; ?>

\Large{<?= $exam->subject_name ?>}
\end{center}

\medskip

<?= $problems ?>

\end{document}
