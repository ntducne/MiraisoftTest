<script setup>
import { ref, watch } from 'vue';

const json = [
  {
    "id": 1,
    "name": "Uploads",
    "children": [
      {
        "id": 10,
        "name": "Images",
        "children": [
          {
            "id": 101,
            "name": "Seasandiego.jpg",
            "url": "https://assets.site-static.com/userFiles/2597/image/2023/CARDIFF_BY_THE_SEA/5-23-2023_1__reasons-why-cardiff-by-the-sea-san-diego-great-place-to-live/9_Reasons_Why_Cardiff-by-the-Sea_San_Diego_.jpg",
            "type": "image/jpg",
            "dimmension": "2000x2000",
            "size": "763300",
            "photo_by": "Admin"
          },
          {
            "id": 102,
            "name": "iMactwin.png",
            "url": "https://i.insider.com/60e4cb0d22d19400191c957c?width=1000&format=jpeg&auto=webp",
            "type": "image/png",
            "dimmension": "2000x2000",
            "size": "640200",
            "photo_by": "Apple"
          },
          {
            "id": 103,
            "name": "hustlecup.jpg",
            "url": "https://images.deliveryhero.io/image/fd-ph/LH/kmph-hero.jpg",
            "type": "image/jpg",
            "dimmension": "2000x2000",
            "size": "100400",
            "photo_by": "Admin"
          },
          {
            "id": 104,
            "name": "MS-Surface.jpg",
            "url": "https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RE4OXzi?ver=3a58",
            "type": "image/jpg",
            "dimmension": "2000x2000",
            "size": "113200",
            "photo_by": "Admin"
          },
          {
            "id": 101,
            "name": "Famoustower.jpg",
            "url": "https://www.worldfamousthings.com/wp-content/uploads/2018/01/Leaning-Tower-of-Pisa-Italy.jpg",
            "type": "image/jpg",
            "dimmension": "2000x2000",
            "size": "763300",
            "photo_by": "Admin"
          }
        ]
      },
      {
        "id": 20,
        "name": "Document",
        "children": []
      },
      {
        "id": 30,
        "name": "Videos",
        "children": [
          {
            "id": 301,
            "name": "GODZILLA MINUS ONE Official Trailer",
            "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
            "type": "video/mp4",
            "dimmension": "2000x2000",
            "size": "763300",
            "photo_by": "Admin"
          },
          {
            "id": 302,
            "name": "Marvel Studios’ Loki Season 2 | October 6 on Disney+",
            "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
            "type": "video/mp4",
            "dimmension": "2000x2000",
            "size": "763300",
            "photo_by": "Admin"
          },
          {
            "id": 302,
            "name": "THE BOY AND THE HERON | Official Teaser Trailer",
            "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
            "type": "video/mp4",
            "dimmension": "2000x2000",
            "size": "763300",
            "photo_by": "Admin"
          }
        ]
      }
    ]
  },
  {
    "id": 2,
    "name": "Sources",
    "children": []
  },
  {
    "id": 3,
    "name": "Shared",
    "children": []
  }
]

const openFolders = ref([]);
const imagesSelected = ref([]);
const oldImagesSelected = ref([]);
const checkedAll = ref(false);
const subFolderSelected = ref(null);
const totalSizeKB = 20 * 1024 * 1024;

const resetValue = () => {
  imagesSelected.value.forEach(image => image.selected = false);
  imagesSelected.value = [];
  oldImagesSelected.value = [];
  subFolderSelected.value = null;
  checkedAll.value = false;
}

const toggleFolder = (id) => {
  resetValue();
  if (openFolders.value.includes(id)) {
    openFolders.value = openFolders.value.filter(folderId => folderId !== id);
  } else {
    openFolders.value.push(id);
  }
};

const getImageSubItem = (id, parent_id) => {
  resetValue();
  if (subFolderSelected.value == id) {
    subFolderSelected.value = null;
    imagesSelected.value = [];
    return;
  }
  var folder = json.find(folder => folder.id === parent_id);
  var subFolder = folder.children.find(subFolder => subFolder.id === id);
  imagesSelected.value = subFolder.children;
  oldImagesSelected.value = subFolder.children;
  subFolderSelected.value = subFolder;
};

const toggleImageSelection = (image) => {
  imagesSelected.value.forEach(image => image.selected = false);
  image.selected = true;
};

const searchImage = (event) => {
  const search = event.target.value.toLowerCase();
  imagesSelected.value = oldImagesSelected.value.filter(image => image.name.toLowerCase().includes(search));
};

watch(checkedAll, (newVal) => {
  if (newVal) {
    imagesSelected.value.forEach(image => image.selected = true);
  } else {
    imagesSelected.value.forEach(image => image.selected = false);
  }
});

let totalSize = 0;
json.forEach(folder => {
  folder.children.forEach(file => {
    if (file.children.length) {
      file.children.forEach(item => {
        totalSize += parseInt(item.size);
      });
    }
  });
});
const progress = ref((totalSize / totalSizeKB) * 100);
progress.value = progress.value > 100 ? 100 : Math.round(progress.value);
</script>

<template>
  <div class="container">
    <div class="header">
      <h1>
        VUEJS 3 - File Manager
      </h1>
    </div>
    <div class="content">
      <div class="left-side">
        <button class="btn-import-document">Import Document</button>
        <div class="storage">
          <div class="storage-title">
            <h3>Storage</h3>
            <a href="">Change Plan</a>
          </div>
          <div class="storage-used" :data-width="progress">
            <div class="storage-fill" :style="{ width: progress + '%' }"></div>
          </div>
          <div class="storage-info">
            <p><span class="percent-used">{{ progress }}%</span> used of 20GB</p>
          </div>
        </div>
        <div class="divider"></div>
        <div class="box-search">
          <input type="text" placeholder="e.g. image.png" id="input-search" @input="searchImage" />
          <img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png" class="icon-input-search"
            alt="" />
        </div>
        <div class="divider"></div>
        <div class="folder">
          <div class="folder-title">
            <h3>Folders</h3>
            <a href="">New Folder</a>
          </div>
          <ul>
            <li v-for="folder in json" :key="folder.id">
              <button class="flex items-center justify-between folder-items" @click="toggleFolder(folder.id)"
                v-if="folder.children.length">
                <div class="flex items-center">
                  <svg width="30" height="30" class="mr-2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                    v-if="!openFolders.includes(folder.id)">
                    <polygon points="40,30 80,50 40,70" fill="#c0c8d0" />
                  </svg>
                  <svg width="30" height="30" class="mr-2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                    v-else>
                    <polygon points="30,60 50,20 70,60" fill="#c0c8d0" />
                  </svg>
                  <img class="mr-1" src="https://img.icons8.com/material-outlined/24/000000/folder-invoices.png"
                    alt="" />
                  <span class="mr-1">{{ folder.name }}</span>
                </div>
                <div class="badge">
                  {{ folder.children.length }}
                </div>
              </button>
              <button class="flex items-center justify-between folder-items" v-else>
                <div class="flex items-center">
                  <svg width="30" height="30" class="mr-2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                    v-if="!openFolders.includes(folder.id)">
                    <polygon points="40,30 80,50 40,70" fill="#c0c8d0" />
                  </svg>
                  <svg width="30" height="30" class="mr-2" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                    v-else>
                    <polygon points="30,60 50,20 70,60" fill="#c0c8d0" />
                  </svg>
                  <img class="mr-1" src="https://img.icons8.com/material-outlined/24/000000/folder-invoices.png"
                    alt="" />
                  <span class="mr-1">{{ folder.name }}</span>
                </div>
              </button>
              <div v-if="openFolders.includes(folder.id)" class="ml-4 sub-folder">
                <ul>
                  <li v-for="subFolder in folder.children" :key="subFolder.id">
                    <button
                      :class="['flex items-center justify-between folder-items', { 'subfolder-active': subFolderSelected && subFolderSelected.id === subFolder.id }]"
                      @click="getImageSubItem(subFolder.id, folder.id)">
                      <div class="flex items-center">
                        <svg width="30" height="30" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                          <polygon points="40,30 80,50 40,70" fill="#c0c8d0" />
                        </svg>
                        <img class="mr-1" src="https://img.icons8.com/material-outlined/24/000000/folder-invoices.png"
                          alt="" />
                        <span class="mr-1">{{ subFolder.name }}</span>
                      </div>
                      <div class="badge">
                        {{ subFolder.children.length }}
                      </div>
                    </button>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="right-side">
        <table border="1">
          <thead>
            <tr>
              <td>
                <input type="checkbox" v-model="checkedAll">
              </td>
              <td>Select All</td>
              <td>Name</td>
              <td>Dimmension</td>
              <td>Size</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="image in imagesSelected" :key="image.id">
              <td>
                <input type="checkbox" v-model="image.selected" @change="toggleImageSelection(image)">
              </td>
              <td><img width="120px" :src="image.url" alt="" /></td>
              <td>{{ image.name }}</td>
              <td>{{ image.dimmension }}</td>
              <td>{{ image.size }} KB</td>
            </tr>
            <tr v-if="!imagesSelected.length" class="text-center">
              <td colspan="5">No Folder Selected</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
