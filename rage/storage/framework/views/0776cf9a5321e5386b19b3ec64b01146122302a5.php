

<?php $__env->startSection('content'); ?>
    <div class="c-title">Топовые <b>комнаты</b></div>
    <div class="viewn-loop">
            <?php foreach($cases_item as $case): ?>
                <?php if($case['place'] == 0): ?>
                <div class="viewn <?php echo e($case['img']); ?> <?php echo e($case['item']); ?>" onclick="return location.href = '/case/<?php echo e($case['id']); ?>'">
    				<!--<div class="klemo klemo-2"></div>-->
                    <div class="viewn-row">
                        <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                        <div class="viewn-rub"><?php echo e($case['max_price']); ?></div>
                        <div class="viewn-text"><?php echo e($case['title']); ?></div>
                    </div>
                    <div class="viewn-info">Содержит от <span><?php echo e($case['min_price']); ?>р</span> до <span><?php echo e($case['max_price']); ?>р</span></div>
                    <div class="viewn-price">Стоимость игры: <b><?php echo e($case['price']); ?>Р</b></div>
                    <a href="/case/<?php echo e($case['id']); ?>" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
    </div>
    <div class="c-title c-title-2">Обычные <b>комнаты</b></div>
    <div class="viewn-loop">
            <?php foreach($cases as $case): ?>
                <?php if($case['place'] == 0): ?>
                <div class="viewn <?php echo e($case['img']); ?>" onclick="return location.href = '/case/<?php echo e($case['id']); ?>'">
    				<!--<div class="klemo klemo-2"></div>-->
                    <div class="viewn-row">
                        <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                        <div class="viewn-rub"><?php echo e($case['max_price']); ?></div>
                        <div class="viewn-text"><?php echo e($case['title']); ?></div>
                    </div>
                    <div class="viewn-info">Содержит от <span><?php echo e($case['min_price']); ?>р</span> до <span><?php echo e($case['max_price']); ?>р</span></div>
                    <div class="viewn-price">Стоимость игры: <b><?php echo e($case['price']); ?>Р</b></div>
                    <a href="/case/<?php echo e($case['id']); ?>" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
<!--
            <div class="viewn viewn-5" onclick="return location.href = '/case/17'">
                                    <div class="klemo klemo-2"></div>
                <div class="viewn-row">
                    <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                    <div class="viewn-rub">1600</div>
                    <div class="viewn-text">Тестовый</div>
                </div>
                <div class="viewn-info">Содержит от <span>100р</span> до <span>1600р</span></div>
                <div class="viewn-price">Стоимость игры: <b>0Р</b></div>
                <a href="/case/17" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
            </div>
            <div class="viewn viewn-5" onclick="return location.href = '/case/5'">
                <div class="viewn-row">
                    <div class="viewn-max">МАКС.ВЫИГРЫШ</div>
                    <div class="viewn-rub">50</div>
                    <div class="viewn-text">Кейс №1</div>
                </div>
                <div class="viewn-info">Содержит от <span>1р</span> до <span>50р</span></div>
                <div class="viewn-price">Стоимость игры: <b>19Р</b></div>
                <a href="/case/5" class="viewn-link">НАЧАТЬ ИГРАТЬ</a>
            </div>
-->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>