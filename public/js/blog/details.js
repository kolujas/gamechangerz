import { InputFileMaker as InputFileMakerJS } from "../../submodules/InputFileMakerJS/js/InputFileMaker.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Asset from "../components/Asset.js";
import Post from "../components/Post.js";

let editor;

new InputFileMakerJS({
    id: 'banner',
    message: 'Elige una imagen',
    button: '',
    name: 'image',
    accept: ['image/jpeg', 'image/png'],
    classes: {
        input: ['form-input'],
        message: ['russo'],
    },
}, {
    generate: document.querySelector('header.image .background'),
    image: (post ? new Asset(`storage/${ post.image }`).route : false),
    disabled: post !== false
});

(async (params) => {
    editor = await window.ckeditor.create( document.querySelector( '#editor' ), {
        toolbar: [ 'heading', 'bold', 'italic', '|', 'undo', 'redo', ],
    } );

    editor.isReadOnly = URL.findOriginalRoute().split('/').pop() !== 'create';

    editor.model.document.on( 'change:data', () => {
        document.querySelector('textarea[name=description]').value = editor.getData();
    });

    if (URL.findHashParameter()) {
        changeStatus(URL.findHashParameter());
    }

    if (URL.findOriginalRoute().split('/').pop() === 'create') {
        Post.setValidationJS('create');
    }
})();

if (document.querySelector('.update-button')) {
    document.querySelector('.update-button').addEventListener('click', function (e) {
        changeStatus('update');
    });
    
    document.querySelector('.delete-button').addEventListener('click', function (e) {
        changeStatus('delete');
    });
    
    document.querySelector('.cancel-button').addEventListener('click', function (e) {
        changeStatus('cancel');
    });
}
    
function changeStatus (status) {
    document.querySelector('#post').action = (status === 'update' ? URL.findOriginalRoute() + "/update" : status === 'delete' ? URL.findOriginalRoute() + "/delete" : URL.findOriginalRoute());
    switch (status) {
        case 'cancel':
            document.querySelector('.update-button').classList.remove('hidden');
            document.querySelector('.delete-button').classList.remove('hidden');
            document.querySelector('.confirm-button').classList.add('hidden');
            document.querySelector('.cancel-button').classList.add('hidden');
            editor.isReadOnly = true;
            modals.deleteMessage.close();
            for (const input of document.querySelectorAll('#post .form-input')) {
                switch (input.name) {
                    case 'image':
                        if (!input.disabled) {
                            input.disabled = true;
                        }
                        document.querySelector('.input-button').disabled = true;
                        break;
                    case 'link':
                        if (!input.disabled) {
                            input.disabled = true;
                        }
                        input.parentNode.classList.add('hidden');
                        input.parentNode.nextElementSibling.classList.remove('hidden');
                        break;
                    default:
                        if (!input.disabled) {
                            input.disabled = true;
                        }
                        break;
                }
            }
            break;
        case 'delete':
            Post.setModalJS();
        case 'update':
            Post.setValidationJS(status);
            document.querySelector('.update-button').classList.add('hidden');
            document.querySelector('.delete-button').classList.add('hidden');
            document.querySelector('.confirm-button').classList.remove('hidden');
            document.querySelector('.cancel-button').classList.remove('hidden');
            editor.isReadOnly = false;
            for (const input of document.querySelectorAll('#post .form-input')) {
                switch (input.name) {
                    case 'image':
                        if (input.disabled) {
                            input.disabled = false;
                        }
                        document.querySelector('.input-button').disabled = false;
                        break;
                    case 'link':
                        if (input.disabled) {
                            input.disabled = false;
                        }
                        input.parentNode.classList.remove('hidden');
                        input.parentNode.nextElementSibling.classList.add('hidden');
                        break;
                    default:
                        if (input.disabled) {
                            input.disabled = false;
                        }
                        break;
                }
            }
            break;
    }
}