<?php
namespace App\Models;

use App\Models\BdModel,
    App\Lib\Response,
    App\Lib\Codigos,
    App\Lib\HasPass,
    App\Lib\Auth;

        class AdminModel{
        private $db=null;
        private $response;
        private $tbCarrera='datos_carrera';
        private $tbDistancia='distancia';
        private $tbAviso='avisos';
        private $tbAcerca='acerca_de';
        private $tbContacto='contacto_carrera';
        private $tbTurismo='turismo';
        private $tbPersona='persona';
        private $tbBoleto='boleto';
        private $tbCupon='cupon';
        private $tbGaleria='galeria';

        public function __construct(){
            $db = new DbModel();
            $this -> db = $db->sqlPDO;
            $this -> response=new Response();
        }

        public function validarAdmin($persona){
            $validacion = $this->db->from($this->tbPersona)
                            ->where('id',$persona)
                            ->fetch();
                if($validacion){
                    return $validacion['tipo_persona'];
                }
                
        }
        public function validarCarrera($parametros, $persona){
            $validacion2 = $this->db->from($this->tbCarrera)
                            ->where('nombreCarrera',$parametros)
                            ->where('persona_id',$persona)
                            ->fetch();
            return $validacion2;
        }

        //carrera
        public function crearCarrera($parametros,$persona){

            $admin= self::validarAdmin($persona);
            if($admin==2){
                $carrera= self::validarCarrera($parametros->nombreCarrera, $persona);
                if(!$carrera){
                    $data = [
                        'nombreCarrera'    => $parametros->nombreCarrera,
                        'lugar'            => $parametros->lugar,
                        'fecha'            => $parametros->fecha,
                        'persona_id'  => $persona,
                        'tema'             => '1'
                    ];
                    
                    $insertCode = $this->db->insertInto($this->tbCarrera)
                                            ->values($data)
                                            ->execute();
    
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha creado una nueva carrera con el nombre {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                return  $this->response->SetResponse(true,"Ya existe la carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                return  $this->response->SetResponse(true,"Al paracer no eres Administrador");
            }

        }
        public function verCarreras($persona){
            $admin= self::validarAdmin($persona);
            if($admin==2){
                $leer = $this->db->from($this->tbCarrera)
                                ->where('persona_id',$persona)
                                ->fetchAll();
                if($leer){
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(true,"Carreras existentes");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parace que aun no tienes carreras");
                }
            }else{
                $this->response->result = null;
                return  $this->response->SetResponse(true,"Al paracer no eres Administrador");
            }
            
        }


        public function actCarrera($parametros,$persona){
            $admin= self::validarAdmin($persona);
            if($admin==2){
                $carrera=self::validarCarrera($parametros->nombreCarrera, $persona);
                if($carrera){
                    $id=$carrera['id'];

                    if($parametros->nuevo==''){
                        $nuevo=$parametros->nombreCarrera;
                    }else{
                        $nuevo=$parametros->nuevo;
                    }

                $data = [
                    'nombreCarrera'    => $nuevo,
                    'lugar'            => $parametros->lugar,
                    'fecha'            => $parametros->fecha,
                    'persona_id'  => $persona,
                    'tema'             => $parametros->tema,
                    'nombre_Organizador'=> $parametros->Organizador,
                    'contacto'         => $parametros->contacto,
                    'capacidadParticipantes' =>$parametros->capacidad,
                    'mensajeCompra' => $parametros->mensaje
                ];
                
                $update = $this->db->update($this->tbCarrera)
                                        ->where('id', $id)
                                        ->set($data)
                                        ->execute();

                $this->response->result = null;
                return  $this->response->SetResponse(true,"Los datos de la carrera {$parametros->nombreCarrera} se han actualizado con exito");
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"Parece que la carrera {$parametros->nombreCarrera} no existe");
                }
            }$this->response->result = null;
            return  $this->response->SetResponse(true,"Parece que no eres administrador");
         }

        public function delCarrera($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $delete=$this->db->delete($this->tbCarrera)
                                    ->where('id',$id)
                                    ->execute();

                $this->response->result = null;
                    return  $this->response->SetResponse(true,"La carrera {$parametros->nombreCarrera} se ha eliminado con éxito");
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que la carrera {$parametros->nombreCarrera} no existe");
            }
                
        }

        //distancias
        public function distance($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);                

            if($validacion){
                $id=$validacion['id'];
                $validacion2=$this->db->from($this->tbDistancia)
                                    ->where('descripcion',$parametros->descripcion)
                                    ->where('datos_carrera',$id)
                                    ->fetch();
                if(!$validacion2){
                    $data=[
                        'kilometros'=>$parametros->kilometros,
                        'capacidad'=>$parametros->capacidad,
                        'datos_carrera'=>$id,
                        'descripcion'=>$parametros->descripcion
                    ];
                    $agregar=$this->db->insertInto($this->tbDistancia)
                                        ->values($data)
                                        ->execute();
                    
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"Se ha agregado la distancia de {$parametros->kilometros} a la carrera {$parametros->nombreCarrera} ");
               
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Ya existe una carrera con ese nombre");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que ha ocurrido un problema");

            }
        }

        public function verDistance($parametros,$persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
                if($validacion){
                    $id=$validacion['id'];
                    $leer = $this->db->from($this->tbDistancia)
                                        ->where('datos_carrera',$id)
                                        ->fetchAll();
                    if($leer){
                        $this->response->result = $leer;
                        return  $this->response->SetResponse(true,"Distancias de la carrera {$parametros->nombreCarrera}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(false,"Parece que aun no tienes alguna distancia en esta carrera");
                    }
                }else{
                    return  $this->response->SetResponse(false,"Parece que la carrera no existe");
                }
        }

        public function nombreDistancia($parametros,$persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
            if($validacion){
                $id=$validacion['id'];
                $leer = $this->db->from($this->tbDistancia)
                                    ->select('descripcion','id')
                                    ->where('datos_carrera',$id)
                                    ->fetchAll();
                if($leer){
                    $this->response->result = $leer;
                    return  $this->response->SetResponse(true,"Distancias de la carrera {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"Parece que la carrera {$parametros->nombreCarrera} no existe");
                }
            }$this->response->result = null;
            return  $this->response->SetResponse(true,"Parece que no eres administrador");
         }

        public function actDistance($parametros,$persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            $idCarrera=$validacion['id'];

            $validacion2=$this->db->from($this->tbDistancia)
                                    ->where('descripcion',$parametros->descripcion)
                                    ->where('datos_carrera',$idCarrera)
                                    ->fetch();
            $idDistancia=$validacion2['id'];

            if($validacion2){
                $data=[
                    'kilometros'=>$parametros->kilometros,
                    'capacidad'=>$parametros->capacidad
                ];
                $update = $this->db->update($this->tbDistancia)
                                            ->where('id', $idDistancia)
                                            ->set($data)
                                            ->execute();
                        $this->response->result = null;
                return  $this->response->SetResponse(true,"Se ha actualizado la distancia {$parametros->descripcion}");
            }else{
                return  $this->response->SetResponse(false,"Parece que ha ocurrido un problema");
            }
        }

        public function delDistance($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2=$this->db->from($this->tbDistancia)
                                    ->where('descripcion',$parametros->descripcion)
                                    ->where('datos_carrera',$id)
                                    ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $delete=$this->db->delete($this->tbDistancia)
                                    ->where('id',$id2)
                                    ->execute();
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"La carrera {$parametros->nombre} se ha eliminado con éxito");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que la distancia {$parametros->descripcion} no existe en la cerrera {$parametros->nombre}");
                }
            
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que la carrera {$parametros->nombre} no existe");
            }
        }

        //avisos

        public function crearAviso($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $data=[
                    'nombre'=>$parametros->nombreAviso,
                    'contenido'=>$parametros->contenido,
                    'datos_carrera'=>$id
                ];
                $agregar=$this->db->insertInto($this->tbAviso)
                                    ->values($data)
                                    ->execute();
                $this->response->result = null;
                return  $this->response->SetResponse(true,"Se ha agregado el aviso {$parametros->nombreAviso} en la cerrera {$parametros->nombreCarrera}");
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"Parece que ha habido un problema");
            }
        }

        public function actAviso($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];

                $validacion2=$this->db->from($this->tbAviso)
                                        ->where('nombre',$parametros->nombreAviso)
                                        ->where('datos_carrera',$id)
                                        ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $data=[
                        'contenido'=>$parametros->contenido
                    ];
                    $update = $this->db->update($this->tbAviso)
                                            ->where('id', $id2)
                                            ->set($data)
                                            ->execute();
                        $this->response->result = null;
                return  $this->response->SetResponse(true,"Se ha actualizado el aviso {$parametros->nombreAviso}");
                }else{
                    $this->response->result = null;
                return  $this->response->SetResponse(true,"No se ha encontrado el aviso {$parametros->nombreAviso}");
                }
            }else{
                    $this->response->result = null;
                return  $this->response->SetResponse(true,"Parece que la carrera no existe");
                }
        }
        
        public function verAviso($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
                if($validacion){
                    $id=$validacion['id'];
                    $leer = $this->db->from($this->tbAviso)
                                        ->where('datos_carrera',$id)
                                        ->fetchAll();
                    if($leer){
                        $this->response->result = $leer;
                        return  $this->response->SetResponse(true,"Avisos de la carrera {$parametros->nombre}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(false,"Parece que aun no tienes algun aviso en esta carrera");
                    }
                }else{
                    return  $this->response->SetResponse(false,"Parece que la carrera no existe");
                }
        }

        public function delAviso($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2= $this->db->from($this->tbAviso)
                                ->where('nombre',$parametros->nombreAviso)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $delete=$this->db->delete($this->tbAviso)
                                    ->where('id',$id2)
                                    ->execute();
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"El aviso {$parametros->nombreAviso} se ha eliminado con éxito");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se ha encontrado algun aviso con el nombre {$parametros->nombreAviso}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe alguna carrera con el nombre {$parametros->nombre}");
            }
        }
        //Acerca de
        public function addAcerca($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbAcerca)
                                ->where('descripcion',$parametros->descripcion)
                                ->where('datos_carrera_id',$id)
                                ->fetch();
                if(!$validacion2){
                    $data=[
                        'descripcion'=>$parametros->descripcion,
                        'contenido'=>$parametros->contenido,
                        'datos_carrera_id'=>$id
                    ];
                    $agregar=$this->db->insertInto($this->tbAcerca)
                                    ->values($data)
                                    ->execute();
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha agregado el acerca de en la carrera {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"ya existe un 'acerca de' para la carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }

        public function actAcerca($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbAcerca)
                                ->where('descripcion',$parametros->descripcion)
                                ->where('datos_carrera_id',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];

                    $data=[
                        'contenido'=>$parametros->contenido
                    ];
                    $agregar=$this->db->update($this->tbAcerca)
                                            ->where('id', $id2)
                                            ->set($data)
                                            ->execute();

                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha actualizado el acerca de en la carrera {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe un 'acerca de' para la carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }
        public function verAcerca($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
                if($validacion){
                    $id=$validacion['id'];
                    $leer = $this->db->from($this->tbAcerca)
                                        ->where('datos_carrera_id',$id)
                                        ->fetchAll();
                    if($leer){
                        $this->response->result = $leer;
                        return  $this->response->SetResponse(true,"'Acerca de' de la carrera {$parametros->nombre}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(false,"Parece que aun no tienes algun 'Acerca de' en esta carrera");
                    }
                }else{
                    return  $this->response->SetResponse(false,"Parece que la carrera no existe");
                }
        }
        public function delAcerca($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2= $this->db->from($this->tbAcerca)
                                ->where('descripcion',$parametros->descripcion)
                                ->where('datos_carrera_id',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $delete=$this->db->delete($this->tbAcerca)
                                    ->where('id',$id2)
                                    ->execute();
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"El 'Acerca de' {$parametros->descripcion} se ha eliminado con éxito");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se ha encontrado algun 'Acerca de' con el nombre {$parametros->descripcion}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe alguna carrera con el nombre {$parametros->nombre}");
            }
        }
        //contacto carrera
        public function addContact($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbContacto)
                                ->where('tipo_contacto',$parametros->tipo)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if(!$validacion2){
                    $data=[
                        'descripcion'=>$parametros->descripcion,
                        'datos_carrera'=>$id,
                        'tipo_contacto'=>$parametros->tipo
                    ];
                    $agregar=$this->db->insertInto($this->tbContacto)
                                    ->values($data)
                                    ->execute();
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha agregado el contacto");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"ya existe este contacto para la carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }

        public function actContact($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbContacto)
                                ->where('descripcion',$parametros->descripcion)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];

                    $data=[
                        'descripcion'=>$parametros->nuevo
                    ];
                    $agregar=$this->db->update($this->tbContacto)
                                            ->where('id', $id2)
                                            ->set($data)
                                            ->execute();

                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha actualizado el contacto de en la carrera {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe este contacto para la carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }

        public function verContacts($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
                if($validacion){
                    $id=$validacion['id'];
                    $leer = $this->db->from($this->tbContacto)
                                        ->where('datos_carrera',$id)
                                        ->fetchAll();
                    if($leer){
                        $this->response->result = $leer;
                        return  $this->response->SetResponse(true,"Formas de contactar al administrador de la carrera {$parametros->nombre}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(false,"Parece que aun no tienes contactos en esta carrera");
                    }
                }else{
                    return  $this->response->SetResponse(false,"Parece que la carrera no existe");
                }
        }
        public function delContact($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2= $this->db->from($this->tbContacto)
                                ->where('descripcion',$parametros->descripcion)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $delete=$this->db->delete($this->tbContacto)
                                    ->where('id',$id2)
                                    ->execute();
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"El contacto {$parametros->descripcion} se ha eliminado con éxito");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se ha encontrado el contacto {$parametros->descripcion}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe alguna carrera con el nombre {$parametros->nombre}");
            }
        }
        //Turismo
        public function addTurismo($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nommbreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbTurismo)
                                ->where('detalles',$parametros->descripcion)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if(!$validacion2){
                    $data=[
                        'url'=>$parametros->url,
                        'detalles'=>$parametros->descripcion,
                        'datos_carrera'=>$id,
                        'tipoTurismo'=>$parametros->tipo
                    ];
                    $agregar=$this->db->insertInto($this->tbTurismo)
                                    ->values($data)
                                    ->execute();
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha agregado exitosamente");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"ya existe este lugar turistico en esta carrera {$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }
        public function actTurismo($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbTurismo)
                                ->where('detalles',$parametros->descripcion)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];

                    $data=[
                        'descripcion'=>$parametros->nuevo
                    ];
                    $agregar=$this->db->update($this->tbTurismo)
                                            ->where('id', $id2)
                                            ->set($data)
                                            ->execute();

                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Se ha actualizado con éxito {$parametros->nombreCarrera}");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"Error, no se puede actualizar{$parametros->nombreCarrera}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se pudo encontrar la carrera {$parametros->nombreCarrera}");
            }
        }
        public function verTurismo($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
                
                if($validacion){
                    $id=$validacion['id'];
                    $leer = $this->db->from($this->tbTurismo)
                                        ->where('datos_carrera',$id)
                                        ->fetchAll();
                    if($leer){
                        $this->response->result = $leer;
                        return  $this->response->SetResponse(true,"Lugares turisticos de la carrera {$parametros->nombre}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(false,"Parece que aun no tienes lugares t en esta carrera");
                    }
                }else{
                    return  $this->response->SetResponse(false,"Parece que la carrera no existe");
                }
        }
        public function delTurismo($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);

            if($validacion){
                $id=$validacion['id'];
                $validacion2= $this->db->from($this->tbTurismo)
                                ->where('detalles',$parametros->descripcion)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $delete=$this->db->delete($this->tbTurismo)
                                    ->where('id',$id2)
                                    ->execute();
                            $this->response->result = null;
                    return  $this->response->SetResponse(true,"El lugar turistico {$parametros->descripcion} se ha eliminado con éxito");
                }else{
                    $this->response->result = null;
                    return  $this->response->SetResponse(true,"No se ha encontrado el lugar {$parametros->descripcion}");
                }
            }else{
                $this->response->result = null;
                    return  $this->response->SetResponse(true,"No existe alguna carrera con el nombre {$parametros->nombre}");
            }
        }

        public function carreras(){
            $carrera=$this->db->from($this->tbCarrera)
                           ->select('id, nombreCarrera, fecha, lugar','id')
                           ->fetchAll();
            return $carrera;
        }

        //boletos
        public function addBoleto($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbDistancia)
                                ->where('descripcion',$parametros->distancia)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $validacion3 = $this->db->from($this->tbBoleto)
                                ->where('distancia',$id2)
                                ->where('carrera',$id)
                                ->fetch();
                    if(!$validacion3){
                        $data=[
                            'precio'=>$parametros->precio,
                            'periodoVentaInicio'=>$parametros->inicio,
                            'periodoVentaFin'=>$parametros->fin,
                            'cantidadBoletos'=>$parametros->cantidad,
                            'tipo_boleto'=>$parametros->tipo,
                            'distancia'=>$id2,
                            'carrera'=>$id
                        ];
                        $agregar=$this->db->insertInto($this->tbBoleto)
                                        ->values($data)
                                        ->execute();
                        $this->response->result = null;

                        return  $this->response->SetResponse(true,"Se ha agregado un boleto exitosamente");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"Ha ocurrido un error");
                    }
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"La distancia no existe");
                }
            }else{
                $this->response->result = null;
                        return  $this->response->SetResponse(true,"La carrera no existe");
            }
        }

        public function verBoleto($parametros,$persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
            if($validacion){
                $id=$validacion['id'];

                    $validacion3 = $this->db->from($this->tbBoleto)
                                ->select('id, precio, periodoVentainicio, periodoVentafin, cantidadBoletos, distancia','id')
                                ->where('carrera',$id)
                                ->fetchAll();

                    if($validacion3){
                         $this->response->result = $validacion3;
                        return  $this->response->SetResponse(true,"Boletos existentes para la carrera {$parametros->nombreCarrera}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"Al parecer aun no tienes boletos para esta carrera");
                    }   
            }else{
                $this->response->result = null;
                        return  $this->response->SetResponse(true,"La carrera no existe");
            }
        }

        public function verBoleto2($parametros,$persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbDistancia)
                                ->where('descripcion',$parametros->distancia)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $validacion3 = $this->db->from($this->tbBoleto)
                                ->where('distancia',$id2)
                                ->where('carrera',$id)
                                ->fetch();

                    if($validacion3){
                        
                        $this->response->result = $validacion3;

                        return  $this->response->SetResponse(true,"Boleto para la distancia {$parametros->distancia}");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"Ha ocurrido un error");
                    }
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"La distancia no existe");
                }
            }else{
                $this->response->result = null;
                        return  $this->response->SetResponse(true,"La carrera no existe");
            }
        }

        public function actBoleto($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbDistancia)
                                ->where('descripcion',$parametros->distancia)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $validacion3 = $this->db->from($this->tbBoleto)
                                ->where('distancia',$id2)
                                ->where('carrera',$id)
                                ->fetch();
                                
                    if($validacion3){
                        $idBoleto=$validacion3['id'];
                        $data=[
                            'precio'=>$parametros->precio,
                            'periodoVentaInicio'=>$parametros->inicio,
                            'periodoVentaFin'=>$parametros->fin,
                            'cantidadBoletos'=>$parametros->cantidad,
                            'tipo_boleto'=>$parametros->tipo,
                        ];
                        $agregar=$this->db->update($this->tbBoleto)
                                        ->where('id',$idBoleto)
                                        ->set($data)
                                        ->execute();
                        $this->response->result = null;

                        return  $this->response->SetResponse(true,"Se ha actualizado un boleto exitosamente");
                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"Ha ocurrido un error");
                    }
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"La distancia no existe");
                }
            }else{
                $this->response->result = null;
                        return  $this->response->SetResponse(true,"La carrera no existe");
            }
        }

        public function delBoleto($parametros, $persona){
            $validacion = self::validarCarrera($parametros->nombreCarrera, $persona);
            if($validacion){
                $id=$validacion['id'];
                $validacion2 = $this->db->from($this->tbDistancia)
                                ->where('descripcion',$parametros->distancia)
                                ->where('datos_carrera',$id)
                                ->fetch();
                if($validacion2){
                    $id2=$validacion2['id'];
                    $validacion3 = $this->db->from($this->tbBoleto)
                                ->where('distancia',$id2)
                                ->where('carrera',$id)
                                ->fetch();
                                
                    if($validacion3){
                        $idBoleto=$validacion3['id'];

                        $delete=$this->db->delete($this->tbBoleto)
                                    ->where('id',$idBoleto)
                                    ->execute();

                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"Se ha eliminado un boleto exitosamente");


                    }else{
                        $this->response->result = null;
                        return  $this->response->SetResponse(true,"no existe el boleto");
                    }
                }else{
                    $this->response->result = null;
                        return  $this->response->SetResponse(true,"La distancia no existe");
                }
            }else{
                $this->response->result = null;
                        return  $this->response->SetResponse(true,"La carrera no existe");
            }
        }

        //imagenes
        public function addImagen($parametros, $imagen,$persona){
            $imageContent = file_get_contents($imagen['imagen']);
            $imageContentBase64 = base64_encode($imageContent);

            $data=[
                'portada'=>$imageContentBase64,
                'datos_carrera'=>$parametros['id'],
            ];

            $agregar=$this->db->insertInto($this->tbGaleria)
                            ->values($data)
                            ->execute();

            $this->response->result = null;
                        return  $this->response->SetResponse(true,"imagen agregada con exito");
         
        }

        public function verImagen($parametros,$persona){
            $validacion3 = $this->db->from($this->tbGaleria)
                                ->select('portada')
                                ->where('datos_carrera',$parametros['id'])
                                ->fetchAll();
            header("Content-type: image/jpeg");
            $this->response->result = $validacion3;
                        return  $this->response->SetResponse(true,"Portada");
        }

}
