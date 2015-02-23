<?php
use Carbon\Carbon;
class BoletinesController extends BaseController {


    public function index()
    {
        $paginacion = Boletines::all();
        return View::make('boletin.index', array('paginacion' => $paginacion));
    }

    public function crear()
    {
        return View::make('boletin.crear');
    }

    public function enviar()
    {
    
        $rules = array(
            "boletin" => "required",
        );
        

        $messages = array(

            "boletin.required" => "El archivo del boletín es requerido",
        );


        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

            $grupo_input=Input::get('grupo');
            $file = Input::file("boletin");
            $fecha=date('d-m-Y');
            $extension = Input::file('boletin')->getClientOriginalExtension();
            $max=Boletines::max('num_boletin')+1;
            $nuevo_nombre= 'Boletin-'.$fecha.'-('.$max.').'.$extension;
            $file->move("boletines/", $nuevo_nombre);

            if($grupo_input=='*'){//Si el grupo es TODOS
                $grupo_input='0'; 
                $contactos=Contactos::all();
                $excluidos=Boletines::where('num_boletin','=','0')->where('id_cli_exc','!=','0')->lists('id_cli_exc');
                    foreach($contactos as $contacto){
                        //Compruebo que el contacto no ha sido añadido a exclusiones
                        if(!in_array($contacto->id_cli, $excluidos)){
                            $datos=array('email'=>$contacto->email, 'nombre'=>$contacto->nombre, 'apell1'=>$contacto->apell1, 'fecha'=>$fecha, 'nuevonombre'=>$nuevo_nombre);
                               Mail::later(25,'emails.boletin', $datos, function($message) use ($datos){
                                $message->to( $datos['email'] , $datos['nombre'].' '.$datos['apell1'] )->subject('Vilches & Herrera - Boletin Informativo!');
                                $message->attach('boletines/'.$datos['nuevonombre']);
                                });
                        }
                        
                    
                   }
                
            }else{
                 $grupos=Grupo::select('id', 'nombre')->get();
                foreach($grupos as $grupo){
                    $clientes=Clientes::where('grupo','=',$grupo->id)->get();
                    foreach($clientes as $cliente){

                        $contactos=Contactos::where('id_cli','=',$cliente->id)->get();
                        foreach($contactos as $contacto){
                            $datos=array('email'=>$contacto->email, 'nombre'=>$contacto->nombre, 'apell1'=>$contacto->apell1, 'fecha'=>$fecha, 'extension'=>$extension);
                               Mail::later(25,'emails.boletin', $datos, function($message) use ($datos){
                                $message->to( $datos['email'] , $datos['nombre'].' '.$datos['apell1'] )->subject('Vilches & Herrera - Boletin Informativo!');
                                $message->attach('boletines/'.$datos['nuevonombre']);
                                });
                       }


                    }
                }

            }
            
            $boletin = Boletines::create(array(
                'num_boletin' => $max,
                'ruta' => 'Boletin-'.$fecha.'-('.$max.')',
                'grupo' => $grupo_input,
                'enviado' => 1,
            ));

            
            //actualizamos los usuarios que se han incluidos o excluidos
            $boletinesactualizar=Boletines::where('num_boletin','=','0')->get();
            foreach($boletinesactualizar as $actualizar){
                $actualizar->num_boletin=$max;
                if($actualizar->id_cli_ani!=0){
                $actualizar->enviado=1;
                }
                $actualizar->save();
            }
            
            $boletin = Boletines::all();
            Event::fire('auditoria', array($boletin->last()->id, Auth::user()->get()->user, $boletin->last(), 'Boletines', 'Alta'));
            return Redirect::action('BoletinesController@index')->withinput()->with('exito','El archivo se ha subido con éxito' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }

     public function eliminarclienteani($id)
    {
        $cliente=Boletines::where('num_boletin','=','0')->where('id_cli_ani','=',$id);
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Clientes::find($id), 'Boletin-Cliente-Añadido', 'Baja'));
        $cliente->delete();

        return Redirect::action('BoletinesController@crear');
    }

    public function aniadircliente()
    {
    
        $rules = array(

            "cliente" => "required|unique:boletines,id_cli_ani,null,id,num_boletin,0",
        );
        

        $messages = array(

            "cliente.required" => "El cliente que quiere añadir es requerido",
            "cliente.unique" => "El cliente seleccionado ya ha sido añadido",
        );

        

        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

            $cliente=Input::get('cliente');
           
            
            $boletin = Boletines::create(array(
                'id_cli_ani' => $cliente,
            ));
            
            $boletin = Boletines::all();
            Event::fire('auditoria', array($boletin->last()->id, Auth::user()->get()->user, $boletin->last(), 'Boletin-Cliente-Añadido', 'Alta'));
            return Redirect::action('BoletinesController@crear')->with('exito','El archivo se ha subido con éxito' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }

    }

    public function eliminarclienteexc($id)
    {
        $cliente=Boletines::where('num_boletin','=','0')->where('id_cli_exc','=',$id);
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Clientes::find($id), 'Boletin-Cliente-Excluido', 'Baja'));
        $cliente->delete();

        return Redirect::action('BoletinesController@crear');
    }

    public function aniadirclienteexc()
    {
    
        $rules = array(
            "excluidos" => "required|unique:boletines,id_cli_exc,null,id,num_boletin,0",
        );
        

        $messages = array(

            "excluidos.required" => "El cliente a excluir es requerido",
            "excluidos.unique" => "El cliente a excluir ya ha sido añadido",
        );


        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

            $cliente=Input::get('excluidos');
           
            
            $boletin = Boletines::create(array(
                'id_cli_exc' => $cliente,
            ));
            
            $boletin = Boletines::all();
            Event::fire('auditoria', array($boletin->last()->id, Auth::user()->get()->user, $boletin->last(), 'Boletin-Cliente-Excluido', 'Alta'));
            return Redirect::action('BoletinesController@crear')->with('exito','El archivo se ha subido con éxito' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }
}