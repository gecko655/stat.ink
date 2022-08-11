<?php

declare(strict_types=1);

use app\assets\TableResponsiveForceAsset;
use app\components\widgets\AdWidget;
use app\components\widgets\CcBy;
use app\components\widgets\SnsWidget;
use app\models\Language;
use app\models\Special3;
use app\models\Special3Alias;
use statink\yii2\sortableTable\SortableTableAsset;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * @var Language[] $langs
 * @var Special3[] $specials
 * @var View $this
 */

$this->context->layout = 'main';
$this->title = Yii::t('app', 'API Info: Weapons (Splatoon 3)');

$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary']);
$this->registerMetaTag(['name' => 'twitter:title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'twitter:site', 'content' => '@stat_ink']);

TableResponsiveForceAsset::register($this);
SortableTableAsset::register($this);

?>
<div class="container">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= AdWidget::widget() . "\n" ?>
  <?= SnsWidget::widget() . "\n" ?>

  <h2><?= Html::encode(Yii::t('app', 'Special')) ?></h2>
  <div class="table-responsive table-responsive-force">
    <table class="table table-striped table-condensed table-sortable">
      <thead>
        <tr>
          <th data-sort="string"><code>key</code></th>
          <th data-sort="string"><?= Html::encode(Yii::t('app', 'Aliases')) ?></th>
<?php foreach ($langs as $i => $lang) { ?>
          <th data-sort="string">
            <?= Html::encode($lang['name']) . "\n" ?>
          </th>
<?php } ?>
        </tr>
      </thead>
      <tbody>
<?php foreach ($specials as $sp) { ?>
        <tr>
          <?= Html::tag(
            'td',
            Html::tag('code', Html::encode($sp->key)),
            [
              'data' => [
                'sort-value' => $sp->key,
              ],
            ]
          ) . "\n" ?>
          <?= Html::tag(
            'td',
            implode(', ', array_map(
              fn (Special3Alias $alias): string => Html::tag('code', Html::encode($alias->key)),
              ArrayHelper::sort(
                $sp->special3Aliases,
                fn (Special3Alias $a, Special3Alias $b): int => strcmp($a->key, $b->key),
              ),
            )),
          ) . "\n" ?>
<?php foreach ($langs as $j => $lang) { ?>
          <?= Html::tag(
            'td',
            Html::encode(Yii::t('app-special3', $sp->name, [], $lang->lang)),
          ) . "\n" ?>
<?php } ?>
<?php } ?>
      </tbody>
    </table>
  </div>
  <hr>
  <?= CcBy::widget() . "\n" ?>
</div>
