import { InputFileMaker as InputFileMakerJS } from "../../submodules/InputFileMakerJS/js/InputFileMaker.js";

import Asset from "../components/Asset.js";

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
    image: new Asset("img/01-background.png").route,
});
// InlineEditor.create( document.querySelector( '#editor' ) )
//     .then( editor => {
//         console.log( editor );
//     } )
//     .catch( error => {
//         console.error( error );
//     } );