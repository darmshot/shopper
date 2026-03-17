import Dropzone from "dropzone";
import Sortable from "sortablejs";
import "/resources/css/admin/components/fx/field/dropzone.css"

Dropzone.autoDiscover = false;

type ServerFile = {
    name: string
    url: string
    size: number,
    path: string,
};

interface DropzoneConfig {
    url: string,
    autoProcessQueue: boolean,
    addRemoveLinks: boolean,
    thumbnailMethod: 'crop' | 'contain',
    uploadMultiple: boolean,
}

interface CreateInputConfig {
    name: string,
    type: string,
    action: string,
    multiple: boolean,
}

const createInput = (config: CreateInputConfig) => {
    const el = document.createElement('input')
    const multipleNameSuffix = config.multiple ? '[]' : '';
    el.type = config.type;
    el.name = `${config.action}_${config.name}${multipleNameSuffix}`;

    return el;
}

interface ExtendedDropzoneFile extends Dropzone.DropzoneFile {
    isMock?: boolean;
    path?: string;
}

export default function (el: HTMLElement) {
    const dropzoneConfig: DropzoneConfig = JSON.parse(el.getAttribute('data-dropzone-config') || "[]");
    const serverFiles = JSON.parse(el.getAttribute('data-server-files') || "[]");
    const name = el.getAttribute('data-name') || '';

    const droppedInput = createInput({
        name,
        action: 'dropped',
        type: 'file',
        multiple: dropzoneConfig.uploadMultiple,
    })
    droppedInput.hidden = true;

    el.appendChild(droppedInput)

    const dz = new Dropzone(el, dropzoneConfig) as Dropzone & { files: ExtendedDropzoneFile[] };

    // Enable sorting
    Sortable.create(el, {
        draggable: ".dz-preview",
        animation: 150,
        ghostClass: "sortable-ghost",
        chosenClass: "sortable-chosen",
        onEnd: function (evt) {
            console.log("Sorted:", evt.oldIndex, "→", evt.newIndex);
        }
    });

    // Style the button after Dropzone creates it
    const btn = el.querySelector(".dz-button");
    if (btn) {
        btn.classList.add("btn", "btn-sm", "btn-primary");
    }

    // Sync files with input
    const syncInput = (file:any) => {

        const dt = new DataTransfer() as DataTransfer & { files: ExtendedDropzoneFile[] };
        dz.files
            // @ts-ignore: Unreachable code error
            .filter(f => !f.isMock)
            .forEach(f => dt.items.add(f));
        droppedInput.files = dt.files;
    };

    dz.on("addedfile", syncInput);
    dz.on("removedfile", syncInput);

    // Track removed server files
    dz.on("removedfile", function (file: any) {
        if (!file.isMock) {
            return
        }

        const input = createInput({
            name,
            action: 'deleted',
            type: 'hidden',
            multiple: dropzoneConfig.uploadMultiple
        });
        // if multiple we worked with array of path images else send boolean value.
        if (dropzoneConfig.uploadMultiple) {
            input.value = file.path;
        }else {
            input.value = '1';
        }
        el.appendChild(input);
    });

    serverFiles.forEach((file: ServerFile) => {
        const mock = {
            name: file.url.split('/').pop(),
            size: file.size,
            isMock: true,
            path: file.path,
        };
        dz.emit("addedfile", mock);
        dz.emit("thumbnail", mock, file.url);
        dz.emit("complete", mock);
    });
}
