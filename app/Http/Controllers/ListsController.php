<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lists;

class ListsController extends Controller
{
    public function store(Request $request)
    {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'contacts.*.name' => 'required|string|max:255',
                'contacts.*.whatsapp' => 'required|string|max:255',
            ]);

            $user_id = auth()->id();

            $array = $request->contacts;
            $lista = array();
            foreach ($array as $key => $contato) {
                $nome = $contato['name'];
                $whatsapp = $contato['whatsapp'];

                // Adiciona cada contato em um array
                $listaContatos[] = [
                    'nome' => $nome,
                    'whatsapp' => $whatsapp
                ];
            }

            // Converte o array de contatos em JSON
            $jsonContatos = json_encode($listaContatos);

    
            $list = new Lists();
            $list->name = $validatedData['name'];
            $list->user_id = $user_id;
            $list->contacts = $jsonContatos;
            $list->save();
    

        return response()->json(['message' => "Lista criada com sucesso"]);
    }

    public function getLists()
    {
        // Obtém o ID do usuário autenticado
        $user_id = auth()->id();

        // Obtém todas as listas do usuário
        $lists = Lists::where('user_id', $user_id)->get();

        return response()->json($lists);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.whatsapp' => 'required|string|max:255',
        ]);


        $id = $request->id;

        $user_id = auth()->id();

        $array = $request->contacts;
        $listaContatos = array();
        foreach ($array as $key => $contato) {
            $nome = $contato['name'];
            $whatsapp = $contato['whatsapp'];

            // Adiciona cada contato em um array
            $listaContatos[] = [
                'nome' => $nome,
                'whatsapp' => $whatsapp
            ];
        }

        // Converte o array de contatos em JSON
        $jsonContatos = json_encode($listaContatos);
        
        // Procura a lista pelo ID e pelo ID do usuário autenticado
        $list = Lists::where('id', $id)->where('user_id', $user_id)->first();

        // Verifica se a lista foi encontrada
        if ($list) {
            // Atualiza os campos da lista
            $list->name = $validatedData['name'];
            $list->contacts = $jsonContatos;
            $list->save();

            return response()->json(['status' => true, 'message' => "Lista atualizada com sucesso"]);
            //return view('campanhas/contatos', ['message' => "Lista atualizada com sucesso"]);
        } else {
            return response()->json(['status' => false,'message' => "Lista não encontrada"], 404);
            //return view('campanhas/contatos', ['message' => "Lista não encontrada"]);

        }
    }



}
