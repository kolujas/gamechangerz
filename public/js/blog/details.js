import { InputFileMaker as InputFileMakerJS } from "../../submodules/InputFileMakerJS/js/InputFileMaker.js";
// import { Editor as InlineEditor } from "../ckeditor5/src/ckeditor.js";

import Asset from "../components/Asset.js";
import Post from "../components/Post.js";

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

Post.setValidationJS();

window.ckeditor.create( document.querySelector( '#editor' ), {
    toolbar: [ 'heading', 'bold', 'italic', '|', 'undo', 'redo', ]
} );