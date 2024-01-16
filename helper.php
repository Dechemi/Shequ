<?php

// 如果数据有效则返回空字符串，如果数据无效则返回错误信息。
function validateString($field, $minlength, $maxlength)
{
    if (strlen($field)<$minlength)
    {
        return "最小长度: " . $minlength;
    }
    elseif (strlen($field)>$maxlength)
    {
        return "最大长度: " . $maxlength;
    }
    // 验证通过，返回空字符串
    return "";
}

function sanitise($str, $connection)
{

    //确保输入的字符串中的特殊字符被正确转义，防止 SQL 注入攻击。
    $str = mysqli_real_escape_string($connection, $str);
    //将字符串中的特殊字符转换为相应的 HTML 实体，以防止跨站脚本攻击
    $str = htmlentities($str);
    return $str;
}

function validateInt($field, $min, $max)
{
    $options = array("options" => array("min_range"=>$min,"max_range"=>$max));

    if (!filter_var($field, FILTER_VALIDATE_INT, $options))
    {
        return "输入有误,应为整数且范围为:" . $min . " ~ " . $max . ")";
    }
    return "";
}

function validateEmail($field)
{
    // 从email中删除所有非法字符
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);

    // 检查电子邮件地址是否符合预期的格式
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
                return "";
    }

    else {
        return "email格式有误 ";
    }
}

function validatePhone($field)
{
    // 从电话号码中删除所有非法字符
    $field = filter_var($field, FILTER_SANITIZE_NUMBER_INT);

    //检查号码长度
    if (strlen($field) <10 || strlen($field) >14) {
                return "";
    }

    else {
        return "请输入正确的号码";
    }
}



?>