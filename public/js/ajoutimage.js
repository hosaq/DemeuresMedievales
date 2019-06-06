$('#add-image').click(function(){
    // numero du futur champs
    const index=+$('#widgets-counter').val();
    //recupère prototype entrée
    const tmpl=$('#annonce_images').data('prototype').replace(/_name_/g,index);
    //injecte le code dans la div
    $('#annonce_images').append(tmpl);
    $('#widgets-counter').val(index+1);
    deleteButtons();
});
function deleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target=this.dataset.target;
        $(target).remove();
    });
}
function updateCompteur(){
    const count=+$('#annonce_images div.form-group').length;
    $('#widgets-counter').val(count);
}
updateCompteur();
deleteButtons();