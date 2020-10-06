function validateCharacter(value, element) {
  value = value.toLowerCase();
  if(value.indexOf('#') != -1){ return false; }
  else if(value.indexOf('!') != -1){ return false; }
  else if(value.indexOf('$') != -1){ return false; }
  else if(value.indexOf('%') != -1){ return false; }
  else if(value.indexOf('/') != -1){ return false; }
  else if(value.indexOf('(') != -1){ return false; }
  else if(value.indexOf(')') != -1){ return false; }
  else if(value.indexOf('=') != -1){ return false; }
  else if(value.indexOf('?') != -1){ return false; }
  else if(value.indexOf('¡') != -1){ return false; }
  else if(value.indexOf('¿') != -1){ return false; }
  else if(value.indexOf("'") != -1){ return false; }
  else if(value.indexOf('´') != -1){ return false; }
  else if(value.indexOf('*') != -1){ return false; }
  else if(value.indexOf('[') != -1){ return false; }
  else if(value.indexOf(']') != -1){ return false; }
  else if(value.indexOf('{') != -1){ return false; }
  else if(value.indexOf('}') != -1){ return false; }
  else if(value.indexOf('+') != -1){ return false; }
  else if(value.indexOf('"') != -1){ return false; }
  else if(value.indexOf('_') != -1){ return false; }
  else if(value.indexOf('|') != -1){ return false; }
  else if(value.indexOf('°') != -1){ return false; }
  else if(value.indexOf('&') != -1){ return false; }
  else if(value.indexOf('>') != -1){ return false; }
  else if(value.indexOf('<') != -1){ return false; }
  else if(value.indexOf('*') != -1){ return false; }
  else{ return true; }
}
$.validator.addMethod("character", validateCharacter);
