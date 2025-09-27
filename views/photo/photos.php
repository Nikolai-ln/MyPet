<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pet $pet */

$this->title = 'Gallery of ' . $pet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['pet/index']];
$this->params['breadcrumbs'][] = ['label' => $pet->name, 'url' => ['pet/view', 'pet_id' => $pet->pet_id]];
$this->params['breadcrumbs'][] = 'Gallery';

$photos = $dataProvider->getModels();
?>

<div class="text-center mb-3">
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<div class="mb-3">
    <?= Html::a('Upload Photo', ['photo/create', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-success me-2']) ?>
    <?= Html::a('List and Update Photos', ['photo/index', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-info']) ?>
</div>

<div class="row justify-content-center">
    <div class="col-auto">
        <table>
            <tr>
                <?php $i = 0; $row = 0; ?>
                <?php foreach ($photos as $photo): ?>
                    <td style="width:270px; height:270px; padding:5px;">
                        <div class="hover-shadow cursor">
                            <img src="<?= Yii::getAlias('@web/' . $photo->path) ?>"
                                 style="width:270px; height:270px; object-fit:cover;"
                                 class="img-thumbnail"
                                 onclick="openModal(<?= $i ?>)">
                        </div>
                    </td>
                    <?php
                    $i++;
                    $row++;
                    if ($row == 3) {
                        echo '</tr><tr>';
                        $row = 0;
                    }
                    ?>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
</div>

<!-- Modal + Carousel -->
<div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header border-0">
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size:2rem">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="5000">

          <!-- Indicators -->
          <ol class="carousel-indicators">
            <?php foreach ($photos as $index => $photo): ?>
              <li data-target="#carouselExample" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
            <?php endforeach; ?>
          </ol>

          <!-- Carousel items -->
          <div class="carousel-inner">
            <?php $active = 'active'; ?>
            <?php foreach ($photos as $photo): ?>
              <div class="carousel-item <?= $active ?>">
                <img src="<?= Yii::getAlias('@web/' . $photo->path) ?>"
                     class="d-block w-100"
                     style="width:100%; height:80vh; object-fit:contain; background-color:grey;"
                     alt="">
              </div>
              <?php $active = ''; ?>
            <?php endforeach; ?>
          </div>

          <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Bootstrap 4 + jQuery
function openModal(index) {
    $('#carouselExample').carousel(index); // показваме правилния слайд
    $('#photoModal').modal('show');        // отваряме modal
}
</script>

<style>
.hover-shadow:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2), 0 6px 20px rgba(0,0,0,0.19);
    cursor: pointer;
}
.carousel-indicators li {
    background-color: white;
}
</style>
