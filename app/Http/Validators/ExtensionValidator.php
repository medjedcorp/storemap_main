<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;
// use Illuminate\Validation\Rule; //ルール使うのに必要
// use App\Models\Category;

class ExtensionValidator extends Validator
{

    /**
     * validateKatakana カタカナのバリデーション（ブランクを許容）
     *
     * @param string $value
     * @access public
     * @return bool
     */
    public function validateKana($attribute, $value, $parameters)
    {
        return (bool) preg_match("/^([　 \t\r\n]|[ぁ-ん]|[ー])+$/u", $value);
    }
    public function validateJptel($attribute, $value, $parameters)
    {
        return (bool) preg_match("/^[0-9]{2,5}-[0-9]{2,4}-[0-9]{3,4}$/", $value);
    }
    public function validateJpzip($attribute, $value, $parameters)
    {
        return (bool) preg_match("/^\d{3}\-\d{4}$/", $value);
    }
    public function validateAlphasign($attribute, $value, $parameters)
    {
        return (bool) preg_match("/^[!-~]+$/", $value);
    }
    public function validateImgName($attribute, $value, $parameters)
    {
        // return (bool) preg_match("/^[-_a-zA-Z0-9]+.(png|jpg|JPG|jpeg|gif|)+$/", $value);
        return (bool) preg_match("/^[-_a-zA-Z0-9]|\.gif$|\.png$|\.jpg$|\.jpeg$|\.JPG$/", $value);
    }
    public function validateAlphaNumeric($attribute, $value, $parameters)
    {
        return (bool) preg_match('/^[a-zA-Z0-9]+$/', $value);
    }
    public function validateSmBar($attribute, $value, $parameters)
    {
        return (bool) preg_match('/^[0-9]|\n|\r\n|\r+$/', $value);
    }
    // public function validateUqcate($attribute, $value, $parameters)
    // {
    //     return (bool) Rule::unique('categories')->ignore($this->input('category_code'))->where(function ($query) {
    //         $query->where('company_id', $this->input('company_id'));
    //     } == $value);
    // }
}
