<?php
/**
 * Created by PhpStorm.
 * User: xoka
 * Date: 9/2/18
 * Time: 9:55 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jackross\SckobkiHelper;

class MainController extends Controller
{

    public function index(Request $request)
    {
        $string = $request->input('string');
        $result = $this->validation($string);
        return response(['message' => $result ? 'validation success' : 'validation error'], $result ? 200 : 400);
    }

    private function validation(string $string): bool
    {
        try {
            return SckobkiHelper::validate($string);
        } catch (\Exception $exception) {
            return false;
        }
    }
}