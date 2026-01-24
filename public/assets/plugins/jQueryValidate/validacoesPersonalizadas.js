jQuery.validator.addMethod("cpf", function (value, element) {
    return this.optional(element) || validarCPF(value);
}, 'CPF inválido.');

jQuery.validator.addMethod("cnpj", function (value, element) {
    return this.optional(element) || validarCNPJ(value);
}, 'CNPJ inválido.');

jQuery.validator.addMethod("telefone", function (value, element) {
    return this.optional(element) || validarTelefone(value);
}, 'Telefone inválido.');

jQuery.validator.addMethod("cep", function (value, element) {
    return this.optional(element) || validarCep(value);
}, 'Cep inválido.');

jQuery.validator.addMethod("dataBR", function (value, element) {
    return this.optional(element) || validarData(value);
}, 'Data inválida.');

jQuery.validator.addMethod("senhaForte", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
}, 'A senha deve ter no mínimo 6 caracteres, com ao menos 1 letra maiúscula, 1 letra minúscula e 1 número.');

jQuery.validator.addMethod("inteiro", function (value, element) {
    return this.optional(element) || validarInteiro(value);
}, 'Número inválido.');

jQuery.validator.addMethod("real", function (value, element) {
    return this.optional(element) || validarReal(value);
}, 'Número inválido.');

jQuery.validator.addMethod( "arquivo", function( value, element, param ) {
	param = typeof param === "string" ? param.replace( /,/g, "|" ) : "doc|xls|png|jpe?g|gif";
	return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
}, 'Tipo de arquivo inválido.' );

jQuery.validator.addMethod( "imagem", function( value, element, param ) {
	param = typeof param === "string" ? param.replace( /,/g, "|" ) : "webp|png|jpe?g|gif";
	return this.optional( element ) || value.match( new RegExp( "\\.(" + param + ")$", "i" ) );
}, 'Tipo de imagem inválida.' );


//validacao jquery validate
jQuery.validator.addMethod( "uniqueValue", function( value, element, param ) {
    let unique = true;
    $(param).each(function(){
        if($(this).val() == value){
            unique = false;
        }
    });
    return unique;
}, 'Item já existente');
