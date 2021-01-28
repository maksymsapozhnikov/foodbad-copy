<?php
/**
 * @var $this \yii\web\View
 */
?>
<div class="modal fade" tabindex="-1" id="modal-window">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= $flash?? '' ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
if(!empty($flash)){
    $this->registerJs("$('#modal-window').modal('show');",$this::POS_READY);
}
$this->registerJs('$("#modal-window").on("hidden.bs.modal", function (event) {$("#modal-window .modal-body").html("")});',$this::POS_READY);

?>
