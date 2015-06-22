<?php

namespace skinka\alertGritter;

use skinka\alertGritter\GritterAsset;
use \yii\bootstrap\Widget;

/**
 * Class AlertGritterWidget
 * @package skinka\alertGritter
 */
class AlertGritterWidget extends Widget {

    public $gritterTypes = [
        'error'   => 'gritter-danger',
        'danger'  => 'gritter-danger',
        'success' => 'gritter-success',
        'info'    => 'gritter-info',
        'warning' => 'gritter-warning'
    ];
    public $gritterIcons = [
        'error'   => 'fa fa-times',
        'danger'  => 'fa fa-times',
        'success' => 'fa fa-check',
        'info'    => 'fa fa-info',
        'warning' => 'fa fa-exclamation-triangle'
    ];
    public function init() {
        parent::init();
        $this->view->registerAssetBundle(GritterAsset::className());
        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            if (isset($this->gritterTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    $this->view->registerJs('$.gritter.add({
                        title: \'<i class="'.$this->gritterIcons[$type].'"></i>\',
                        text: \''.$message.'\',
                        class_name: \''.$this->gritterTypes[$type].' gritter-icon\',
                    });');
                }
                $session->removeFlash($type);
            }
        }
    }
}
