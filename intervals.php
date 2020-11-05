<?php

function intervalConstruction ($arr)
{
    $str = 'Cb C C# Db D D# Eb E E# Fb F F# Gb G G# Ab A A# Bb B B#';

    $arr_semitone_and_degree = array(
        'm2' =>  array( 1 , 2),
        'M2' => array( 2 , 2),
        'm3' => array( 3 , 3),
        'M3' => array( 4 , 3),
        'P4' => array( 5 , 4),
        'P5' => array( 7 , 5),
        'm6' => array( 8 , 6),
        'M6' => array( 9 , 6),
        'm7' => array( 10 , 7),
        'M7' => array( 11 , 7),
        'P8' => array( 12 ,  8),
    );

    foreach ($arr_semitone_and_degree as $key => $value){
        if ($key == $arr[0]) {
            foreach ($arr_semitone_and_degree[$key] as $value_two) {
                $need_semitone = $arr_semitone_and_degree[$key][0];
                $need_degree = $arr_semitone_and_degree[$key][1];
            }
        }
    }

    $arr_str = preg_split('/ /', $str, -1, PREG_SPLIT_NO_EMPTY);

    // for reverse count
    if ($arr[2] == 'dsc'){
        $arr_str  = array_reverse($arr_str);
    }

    // for new line, when row is ending
    $arr_with_two_rows = array();
    $kol_loop = 0;
    while ($kol_loop < 2) {
        foreach ($arr_str as $key => $value) {
            array_push($arr_with_two_rows, $value);
        }
        $kol_loop++;
    }
    //Choosing position start of array
    foreach ($arr_with_two_rows as $key => $value) {
        if (preg_match("/^$arr[1]$/", $value)) {
            $start_pos_arr = array_slice($arr_with_two_rows, $key);
            break;
        }
    }

    $stack_degree = array();
    $stack_semitone = array();
    $count = 0;

    foreach ($start_pos_arr as $key => $value) {
        if ($count < $need_degree) {
            if (preg_match("/[A-Z]$/", $value)) {
                array_push($stack_degree, $value);
                $count++;
            } else {
                array_push($stack_semitone, $value);
            }
        }
    }

    $last_element = end($stack_degree);

    $count_stack_semitone = count($stack_semitone);


    if ($count_stack_semitone - $need_semitone == -1)  {
        $result = $last_element.'#';
    } elseif ($count_stack_semitone - $need_semitone == -2) {
        $result = $last_element.'##';
    } elseif ($count_stack_semitone - $need_semitone == 1) {
        $result = $last_element.'b';
    } elseif ($count_stack_semitone - $need_semitone == 2) {
        $result = $last_element.'bb';
    } elseif ($count_stack_semitone - $need_semitone == 0) {
        echo  $result = $last_element;
    } else {
        $result = 'Interval is missing';
    }
    return $result;
}



function intervalIdentification  ($arr)
{
    $str =  'Cbb Cb C C# C## Dbb Db D D# D## Ebb Eb E E# E## Fbb Fb F F# F## Gbb Gb G G# G## Abb Ab A A# A## Bbb Bb B B# B##';
    $arr_str = preg_split('/ /', $str, -1, PREG_SPLIT_NO_EMPTY);
    // for reverse count
    if ($arr[2] == 'dsc'){
        $arr_str  = array_reverse($arr_str);
    }
    // for new line, when row is ending
    $arr_with_two_rows = array();
    $kol_loop = 0;
    while ($kol_loop < 2) {
        foreach ($arr_str as $key => $value) {
            array_push($arr_with_two_rows, $value);
        }
        $kol_loop++;
    }

    //Choosing position start  of array
    foreach ($arr_with_two_rows as $key => $value) {
        if (preg_match("/^$arr[0]$/", $value)) {
            $start_pos_arr = array_slice($arr_with_two_rows, $key);
            break;
        }
    }

    //Create a correct array
    $correct_arr = array();

    foreach ($start_pos_arr as $key => $value) {
        array_push($correct_arr, $value );
        if ($value == $arr[1] ){
            break;
        }
    }

    $count_degree = 0;
    $count_semitone = 0;
    $stack_degree = array();
    $stack_semitone = array();

    foreach ($correct_arr as $key => $value) {
        if (preg_match("/^[A-Z]$/", $value)) {
            array_push($stack_degree, $value);
            $count_degree++;
        } else if (preg_match("/^[A-Z][#b]$/", $value)) {
            array_push($stack_semitone, $value);
            $count_semitone++;
        }
    }

    $arr_semitone_and_degree = array(
        'm2' =>  array( 1 , 2),
        'M2' => array( 2 , 2),
        'm3' => array( 3 , 3),
        'M3' => array( 4 , 3),
        'P4' => array( 5 , 4),
        'P5' => array( 7 , 5),
        'm6' => array( 8 , 6),
        'M6' => array( 9 , 6),
        'm7' => array( 10 , 7),
        'M7' => array( 11 , 7),
        'P8' => array( 12 ,  8),
    );

    foreach ($arr_semitone_and_degree as $key => $value){
        foreach ($arr_semitone_and_degree[$key] as $value_two) {

            if ($count_degree == $arr_semitone_and_degree[$key][1]){
                $result = $key;
                break;
            } elseif ($count_degree == 1 ) {
                $result = 'm2';
                break;
            } elseif ($count_degree > 8  ) {
                $result = 'P8';
            } elseif ($count_degree == 0 ) {
                $result = 'interval is missing';
            }
        }
    }
    return $result;
}