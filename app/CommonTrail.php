<?php

namespace App;

trait CommonTrail
{

    public function actionButtonHtml($id, $baseurl)
    {
        $url = "<div style='width:100px' class='actions-a'>
        <a class='btn-circle btn btn-dark btn-sm module_view_record' data-id='" . $id . "' data-url='" . $baseurl . "' title='View'><i class='text-info fas fa-eye'></i></a>
        <a class='btn-circle btn btn-dark btn-sm module_edit_record' data-id='" . $id . "' data-url='" . $baseurl . "' title='Edit'><i class='text-warning far fa-edit'></i></a>
        <a class='btn-circle btn btn-dark btn-sm module_delete_record' data-id='" . $id . "' data-url='" . $baseurl . "' title='Delete'><i class='text-danger far fa-trash-alt'></i></a>
        </div>";
        return $url;
    }
}
