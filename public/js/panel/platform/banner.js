import { InputFileMaker } from "../../../submodules/InputFileMakerJS/js/InputFileMaker.js";
import { Asset } from "../../components/Asset.js";

new InputFileMaker({
    accept: ['image/png'],
    button: 'Cargar imagen',
    classes: {
        input: ['banner-pic'],
        button: ['banner-button', 'btn', 'btn-outline', 'btn-one', 'my-8'],
        message: ['banner-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'banner-photo',
    name: 'banner'
},{
    generate: document.querySelector('.banner-photo'),
    image: new Asset('storage/web/01-banner.png').route
});

new InputFileMaker({
    accept: ['image/jpeg'],
    button: 'Cargar imagen',
    classes: {
        input: ['bg-banner'],
        button: ['bg-banner', 'btn', 'btn-outline', 'btn-one', 'my-8'],
        message: ['bg-banner-msg', 'color-white']
    },
    message: 'No es una imagen válida',
    id: 'bg-banner',
    name: 'background'
},{
    generate: document.querySelector('.bg-banner'),
    image: new Asset('storage/web/02-background.jpg').route
});