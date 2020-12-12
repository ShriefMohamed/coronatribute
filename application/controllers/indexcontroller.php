<?php


namespace Framework\controllers;

use Framework\lib\AbstractController;
use Framework\lib\FilterInput;
use Framework\lib\Helper;
use Framework\lib\Redirect;
use Framework\lib\Request;
use Framework\lib\Text;
use Framework\models\LoginModel;
use Framework\models\Memorial_photosModel;
use Framework\models\Memorial_storiesModel;
use Framework\models\Memorial_tributesModel;
use Framework\models\MemorialsModel;

/**
 * Class IndexController
 *
 * @package   Framework\controllers
 *
 * @author    Shrief Mohamed
 *
 * Description
 */
class IndexController extends AbstractController
{
    public function DefaultAction()
    {
        $memorial = MemorialsModel::GetMemorialsWithPhoto(" ORDER BY RAND() LIMIT 100");
        $tributes = Memorial_tributesModel::GetAllTributes("ORDER BY memorial_tributes.created DESC LIMIT 6");
        $cases_updates = file_exists(APPLICATION_DIR . 'corona_updates.txt') ? @json_decode(file_get_contents(APPLICATION_DIR . 'corona_updates.txt')) : '';
        $this->_template->SetTitle(WEBSITE_NAME . ' - Coronavirus victims as stories, not numbers.')
            ->SetData(['memorials' => $memorial, 'tributes' => $tributes, 'cases_updates' => $cases_updates])
            ->SetViews(['header', 'slider', 'view'])
            ->Render();
    }

    public function SearchAction()
    {
        if (Request::Check('search')) {
            $keyword = FilterInput::String(Request::Post('search', false, true));
            $data = MemorialsModel::Search($keyword);

            $this->_template
                ->SetTitle('Results for '.$keyword.' - ' . WEBSITE_NAME)
                ->SetData(['memorials' => $data])
                ->SetViews(['header', 'view'])
                ->Render();
        }
    }

    public function Create_memorialAction()
    {
        $this->_template->SetData([])
            ->SetTitle('Create a Memorial - ' . WEBSITE_NAME)
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function MemorialAction()
    {
        $id = isset($this->_params) ? $this->_params[0] : false;
        if ($id !== false) {
            $where_ = is_numeric($id) ? "memorials.id" : "memorials.webAddress";
            $memorial = MemorialsModel::GetMemorialDetails("WHERE $where_ = '$id'");
            if ($memorial) {
                $memorial_stories = Memorial_storiesModel::GetAll("WHERE memorial_id = '$id' ORDER BY created DESC");
                $photos = Memorial_photosModel::GetPhotos("WHERE memorial_photos.memorial_id = '$id' ORDER BY memorial_photos.feature, memorial_photos.updated DESC");
                $tributes = Memorial_tributesModel::GetAllTributes("WHERE memorial_id = '$id' ORDER BY memorial_tributes.created DESC");

                $birth_year = isset($memorial->birthDate) && $memorial->birthDate ? date('Y', strtotime($memorial->birthDate)) : '';
                $passing_year = isset($memorial->passingDate) && $memorial->passingDate ? date('Y', strtotime($memorial->passingDate)) : '';
                $age = ($memorial->birthDate && $memorial->passingDate) ? Helper::CalcAge($memorial->birthDate, $memorial->passingDate) : false;

                $birth_passing_date = ($birth_year && $passing_year) ? ' ('.$birth_year.'-'.$passing_year.')' : '';
                $this->_template
                    ->SetData([
                        'memorial' => $memorial,
                        'memorial_stories' => $memorial_stories,
                        'photos' => $photos,
                        'tributes' => $tributes,
                        'age' => $age,
                        'birth_passing_date' => $birth_passing_date
                    ])
                    ->SetTitle(ucfirst($memorial->firstName).' '.ucfirst($memorial->lastName).$birth_passing_date.' Online Memorial')
                    ->SetViews(['header', 'view'])
                    ->Render();
            } else {
                Redirect::NotFound();
            }
        }
    }

    public function AboutAction()
    {
        $this->_template
            ->SetTitle('About Us - ' . WEBSITE_NAME)
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function ContactAction()
    {

        $this->_template
            ->SetTitle('Contact us' . ' - ' . WEBSITE_NAME)
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function PrivacyAction()
    {
        $this->_template
            ->SetTitle('Privacy Policy - ' . WEBSITE_NAME)
            ->SetViews(['header', 'view'])
            ->Render();
    }

    public function TermsAction()
    {
        $this->_template
            ->SetTitle("Terms of Service - " . WEBSITE_NAME)
            ->SetViews(['header', 'view'])
            ->Render();
    }
}