<?php

namespace NFSe\Lib;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;	

class Validatr
{
	protected static $jsonSchema = '{
	    "title": "RPS",
	    "type": "object",
	    "properties": {
	        "tipo": {
	            "required": true,
	            "type": "string",
	            "pattern": "^(RPS|RPC)$"
	        },
	        "numero": {
	            "required": true,
	            "type": "integer",
	            "minimum": 1,
	            "maximum": 999999999
	        },
	        "serie": {
	            "required": true,
	            "type": "string",
	            "pattern": "^.{1,3}$"
	        },
	        "dtemi": {
	            "required": true,
	            "type": "string",
	            "pattern": "^(2[0-9]{3}-(((0[13578]|1[02])-([0-2]{1}[0-9]{1}|3[01]))|(02-([0-2]{1}[0-9]{1}))|((0[469]|11)-([0-2]{1}[0-9]{1}|30))))$"
	        },
	        "retfonte": {
	            "required": true,
	            "type": "string",
	            "pattern": "^(SIM|NAO)$"
	        },
	        "codsrv": {
	            "required": true,
	            "type": "string",
	            "pattern": "^.{1,10}$"
	        },
	        "discrsrv": {
	            "required": true,
	            "type": "string",
	            "pattern": "^.{1,4000}$"
	        },
	        "vlnfs": {
	            "required": true,
	            "type": "number"
	        },
	        "vlded": {
	            "required": true,
	            "type": "number"
	        },
	        "discrded": {
	            "required": false,
	            "type": ["string","null"],
	            "pattern": "^.{0,4000}$"
	        },
	        "alqiss": {
	            "required": true,
	            "type": "number"
	        },
	        "vlissret": {
	            "required": true,
	            "type": "number"
	        },
	        "tomador": {
	            "required": true,
	            "type": "object",
	            "properties": {
	                "cpfcnpj": {
	                    "required": true,
	                    "type": "string",
	                    "pattern": "^([0-9]{11,14}|CONSUMIDOR|EXTERIOR)$"
	                },
	                "razsoc": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,60}$"
	                },
	                "tipolog": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^(RUA|AVENIDA|PRAÇA|ALAMEDA)$"
	                },
	                "log": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,60}$"
	                },
	                "numend": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,10}$"
	                },
	                "complend": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,60}$"
	                },
	                "bairro": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,60}$"
	                },
	                "mun": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{1,60}$"
	                },
	                "siglauf": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{2}$"
	                },
	                "cep": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^[0-9]{8}$"
	                },
	                "telefone": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^[0-9]{6,12}$"
	                },
	                "inscricaomunicipal": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^[0-9]{5,20}$"
	                },
	                "email1": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{2,120}$"
	                },
	                "email2": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{2,120}$"
	                },
	                "email3": {
	                    "required": false,
	                    "type": ["string","null"],
	                    "pattern": "^.{2,120}$"
	                },
	                "localprestacao": {
	                    "required": false,
	                    "type": ["object","null"],
	                    "properties": {
	                        "tipolog": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^(RUA|AVENIDA|PRAÇA|ALAMEDA)$"
	                        },
	                        "log": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^.{1,60}$"
	                        },
	                        "numend": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^.{1,10}$"
	                        },
	                        "complend": {
	                            "required": false,
	                            "type": ["string","null"],
	                            "pattern": "^.{1,60}$"
	                        },
	                        "bairro": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^.{1,60}$"
	                        },
	                        "mun": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^.{1,60}$"
	                        },
	                        "siglauf": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^.{2}$"
	                        },
	                        "cep": {
	                            "required": true,
	                            "type": "string",
	                            "pattern": "^[0-9]{8}$"
	                        }
	                    }
	                }
	            }
	        },
	        "tributos": {
	            "required": false,
	            "type": ["array","null"],
	            "minItems": 0,
	            "maxItems": 5,
	            "items": {
	                "type": "object",
	                "properties": {
	                    "sigla": {
	                        "required": true,
	                        "type": "string",
	                        "pattern": "^(COFINS|CSLL|INSS|IR|PIS)$"
	                    },
	                    "aliquota": {
	                        "required": true,
	                        "type": "number"
	                    },
	                    "valor": {
	                        "required": true,
	                        "type": "number"
	                    }
	                }
	            }    
	        }
	    }
	}';

	public static function validate($std) 
	{

		$jsonSchemaObject = json_decode(self::$jsonSchema);

		$schemaStorage = new SchemaStorage();
		$schemaStorage->addSchema('file://mySchema', $jsonSchemaObject);
		$jsonValidator = new Validator(new Factory($schemaStorage));
		// Do validation (use isValid() and getErrors() to check the result)
		$jsonValidator->validate(
		    $std,
		    $jsonSchemaObject,
		    Constraint::CHECK_MODE_COERCE_TYPES  //tenta converter o dado no tipo indicado no schema
		);
		if ($jsonValidator->isValid()) {
		    return;
		} else {
		    $errors = [];
		    $errors[] = "Dados não validados. Violações:<br/>";
		    foreach ($jsonValidator->getErrors() as $error) {
		        $errors[] = "[{$error['property']}], {$error['message']})";
		    }
		    
		    throw new \Exception(join('<br />', $errors));
		}
	}
}