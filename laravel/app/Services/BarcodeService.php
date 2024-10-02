<?php

namespace App\Services;

use App\Models\Format;
use App\Models\Movie;

class BarcodeService
{
    public function generate(Movie $movie, Format $format) 
    {
        $barcode = explode(' ', $movie->title);

        $barcode = $barcode[0] . (count($barcode) > 1 ? end($barcode) : '') . '-' . $movie->year . '-' . $format->type;
        
        // $barcode = mb_strtoupper(sprintf('%s%s-%s-%s',
        //     $barcode[0],
        //     count($barcode) > 1 ? end($barcode) : '',
        //     $movie->year,
        //     str_replace('-', '', $format->type)
        // ));

        return $barcode;
    }
}