project = {
    name : 'PROJET_WEB_1'
  };
  
  function form_action(form_id)
  {
    // récupérer le formulaire via l'id en argument
    form = document.getElementById(form_id);
  
    // récupérer l'action du formulaire
    action = form.getAttribute('action');
  
    // récupérer le contrôleur et la méthode à appeler
    controller = action.split('.')[0];
    method = action.split('.')[1];
  
    // générer la vrai url d'action du formulaire
    url = '/' + project.name + '/controller/' + controller + '.php';
  
    // créer un paramètre caché qui contient l'action
    input = document.createElement('input');
    input.setAttribute('type','hidden');
    input.setAttribute('name','action');
    input.setAttribute('value',method);
  
    // ajouter l'input au formulaire
    form.appendChild(input);
  
    // remplacer l'action virtuelle par la vraie action
    form.setAttribute('action', url);
  
    // valider le formulaire pour envoyer les données au contrôleur définit dans l'action
    form.submit();
  }