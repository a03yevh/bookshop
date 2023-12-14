<?php

use yii\helpers\Html;

?>
<div class="footer__contact">
    <h5 class="footer__nav-title">Контакти</h5>


    <nav class="footer__nav footer__nav--contact">
        <ul class="footer__nav-list">
            <?php if ($phone !== null): ?>
                <li class="footer__nav-item">
                    <span class="footer__nav-text">Зателефонуйте нам</span>
                    <a class="footer__nav-link footer__nav-link--undl" href="tel:%2B<?= str_replace(['+', '(', ')', ' '], '', $phone->value) ?>">
                        <?= $phone->value ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($email !== null): ?>
                <li class="footer__nav-item">
                    <span class="footer__nav-text">Зв'яжіться з нами за поштою</span>
                    <a class="footer__nav-link footer__nav-link--undl" href="mailto:<?= $email->value ?>">
                        <?= $email->value ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="footer__nav-list">
            <li class="footer__nav-item">
                <span class="footer__nav-text">Cоціальні мережі</span>
            </li>
            <?php if ($instagram !== null):
                $nic = str_replace('/', '', mb_substr($instagram->value, 26));
                ?>
                <li class="footer__nav-item">
                    <a class="footer__nav-link" href="<?= $instagram->value ?>" target="_blank">
                        <?= Html::img('@web/img/icons/instagram.svg', ['class' => 'footer__nav-icon', 'alt' => 'Instagram @' . $nic, 'width' => 20, 'height' => 20]) ?>
                        <span class="footer__nav-text footer__nav-text--social">@<?= $nic ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>