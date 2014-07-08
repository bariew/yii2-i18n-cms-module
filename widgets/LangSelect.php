<?php
/**
 * LangSelect class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\i18nModule\widgets;

use yii\base\Widget;

/**
 * Dropdown for language selection.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class LangSelect extends Widget
{
    /**
     * @var string view file name.
     */
    public $view = 'langSelect';

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->view);
    }
}