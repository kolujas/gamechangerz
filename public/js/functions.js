/**
 * * Print a <input> value in a <video>.
 * @param {nodeElement} input
 * @param {nodeElement} video
 */
export function printVideo (input, video) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

    var match = input.value.match(regExp);

    let videoId;

    if (match && match[2].length == 11) {
        videoId = match[2];
    } else {
        videoId = 'error';
    }

    if (videoId == 'error') {
        video.html(`<a href='${ input.value }' class='w-full russo color-black btn btn-one btn-outline' target='_blank'><span class='px-4 py-2 text-lg'>Material enviado</span></a>`);
    } else {
        video.html(`<iframe src='//www.youtube.com/embed/${ videoId }' frameborder='0' allowfullscreen></iframe>`);
    }
}

export default {
    printVideo: printVideo,
}