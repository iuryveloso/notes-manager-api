<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)->get();
        return $notes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [ 
            'title.required' => 'O Título é obrigatório!',
            'title.max' => 'O Título deve ter menos de 255 caracteres!',
            'body.required' => 'O Corpo do texto é obrigatório!',
            'color.required' => 'A Cor da nota é obrigatória!',
            'color.max' => 'A Cor deve ter menos de 255 caracteres!',
            'favorited.boolean' => 'O Favorito está incorreto!',
            'favorited.required' => 'O Favorito é obrigatório!',
        ];

        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'color' => 'required|max:255',
            'favorited' => 'boolean|required'
        ], $messages);

        $request->user()->notes()->create($fields);
        return ['messsage' => 'Nota salva!'];
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return $note;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        Gate::authorize('modify', $note);

        $messages = [ 
            'title.required' => 'O Título é obrigatório!',
            'body.required' => 'O Corpo do texto é obrigatório!',
            'color.required' => 'A Cor da nota é obrigatória!',
            'favorited.boolean' => 'O Favorito está incorreto!',
            'favorited.required' => 'O Favorito é obrigatório!',
        ];

        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'color' => 'required|max:255',
            'favorited' => 'boolean|required'
        ], $messages);
        $note->update($fields);
        return ['messsage' => 'Nota atualizada!'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        Gate::authorize('modify', $note);
        $note->delete();
        return ['messsage' => 'Nota removida!'];
    }

    /**
     * Restore the specified resource to storage.
     */
    public function restore(String $id)
    {
        $note = Note::withTrashed()->find($id);
        Gate::authorize('modify', $note);
        $note->restore();
        return ['messsage' => 'Nota restaurada!'];
    }
}
