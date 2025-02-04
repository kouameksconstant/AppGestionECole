<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe; // Assurez-vous que le modèle Classe existe

class ClassController extends Controller
{
    public function manage($class)
    {
        // Vous pouvez récupérer la classe depuis la base de données
        $classData = Classe::find($class);
        
        if (!$classData) {
            abort(404, 'Class not found');
        }

        return view('class.manage', compact('classData'));
    }
}
