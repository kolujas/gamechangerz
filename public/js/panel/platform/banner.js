import { Asset } from "../../components/Asset.js";

new window.inputfile({
    accept: ["image/png"],
    button: "Cargar imagen",
    classes: {
        input: ["banner-pic"],
        button: ["banner-button", "btn", "btn-outline", "btn-one", "my-8"],
        message: ["banner-msg", "color-white"]
    },
    message: "",
    id: "banner-photo",
    name: "slider-1"
},{
    generate: document.querySelector(".banner-photo div div:first-of-type"),
    image: new Asset("storage/web/slider/01-banner.png").route
});

new window.inputfile({
    accept: ["image/png"],
    button: "Cargar imagen",
    classes: {
        input: ["banner-pic"],
        button: ["banner-button", "btn", "btn-outline", "btn-one", "my-8"],
        message: ["banner-msg", "color-white"]
    },
    message: "",
    id: "banner-photo",
    name: "slider-2"
},{
    generate: document.querySelector(".banner-photo div div:nth-of-type(2)"),
    image: new Asset("storage/web/slider/02-banner.png").route
});

new window.inputfile({
    accept: ["image/png"],
    button: "Cargar imagen",
    classes: {
        input: ["banner-pic"],
        button: ["banner-button", "btn", "btn-outline", "btn-one", "my-8"],
        message: ["banner-msg", "color-white"]
    },
    message: "",
    id: "banner-photo",
    name: "slider-3"
},{
    generate: document.querySelector(".banner-photo div div:last-of-type"),
    image: new Asset("storage/web/slider/03-banner.png").route
});

new window.inputfile({
    accept: ["image/jpeg"],
    button: "Cargar imagen",
    classes: {
        input: ["bg-banner"],
        button: ["bg-banner", "btn", "btn-outline", "btn-one", "my-8"],
        message: ["bg-banner-msg", "color-white"]
    },
    message: "",
    id: "bg-banner",
    name: "background"
},{
    generate: document.querySelector(".bg-banner"),
    image: new Asset("storage/web/01-background.png").route
});

document.querySelector("#tab-platform").classList.add("opened");