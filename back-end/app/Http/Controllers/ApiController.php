<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    public function findShortestPath(Request $request)
    {
        $array = array();
        foreach ($request->input('numbers_array') as $key => $array_element) {
           array_push($array, $array_element['element']);
        }

        if (count($array) <= 1) {
            return response()->json(['message' => 'Add more elments to array', 'path' => null, 'steps' => null]);
        }

        $steps[0] = 0;
        $jumps[0] = 0;
        $path_keys[0] = 0;
        $jumps_path[0] = $array[0];
        $path_key = 0;

        for ($i = 1; $i < count($array); $i++) {
            $steps[$i] = PHP_INT_MAX;
            for ($j = 0; $j < $i; $j++) { 
                if ($i <= $j + $array[$j]) { 
                    $steps[$i] = min($steps[$i], $steps[$j] + 1);
                    $jumps[$i] = $j;
                    break; 
                } 
            }

            if ($steps[$i] === PHP_INT_MAX) {
                return response()->json(['message' => 'End of array is unreachable', 'path' => null, 'steps' => null]);
            }
        }

        //look for original array keys from where were jumped
        for ($i = count($jumps) - 1; $i >= 0; $i--) {
            $i = $jumps[$i];
            $path[$path_key++] = $i;
        }

        //get jumps path
        $key = 0;
        for ($i = count($path) - 1; $i >= 0; $i--) {
            $jumps_path[$key++] = $array[$path[$i]];
        }

        return response()->json(['message' => 'You reached the end!', 'path' => $jumps_path, 'steps' => count($jumps_path)]);
    }
}
