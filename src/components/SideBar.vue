<template>
  <div class="side-bar">
    <div class="side-bar-wrapper">
      <h3 class="side-bar-header">Departments</h3>
      <ul class="side-bar-lists">
        <li class="side-bar-list" :class="{ active: menuItemIndex === 1 }" @click="changeMenuTitle('Adminstration')">
          <img v-if="menuItemIndex === 1" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Adminstration</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 2 }" @click="changeMenuTitle('Admissions')">
          <img v-if="menuItemIndex === 2" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Admissions</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 3 }" @click="changeMenuTitle('Communications')">
          <img v-if="menuItemIndex === 3" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Communications</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 4 }" @click="changeMenuTitle('IT')">
          <img v-if="menuItemIndex === 4" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">IT</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 5 }" @click="changeMenuTitle('Student Affairs')">
          <img v-if="menuItemIndex === 5" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Student Affairs</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 6 }" @click="changeMenuTitle('Facilities')">
          <img v-if="menuItemIndex === 6" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Facilities</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 7 }" @click="changeMenuTitle('Trannsportation')">
          <img v-if="menuItemIndex === 7" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Trannsportation</span>
        </li>
        <li class="side-bar-list" :class="{ active: menuItemIndex === 8 }" @click="changeMenuTitle('Food Service')">
          <img v-if="menuItemIndex === 8" src="../assets/svg-icons/faFolderOpen.svg" alt="">
          <img v-else src="../assets/svg-icons/faFolder.svg" alt="">
          <span class="side-bar-dept-name">Food Service</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menuItemIndex: 1
    }
  },
  methods: {
    changeMenuTitle(dept) {
      switch (dept) {
        case 'Adminstration':
          this.menuItemIndex = 1;
          break;
        case 'Admissions':
          this.menuItemIndex = 2;
          break;
        case 'Communications':
          this.menuItemIndex = 3;
          break;
        case 'IT':
          this.menuItemIndex = 4;
          break;
        case 'Student Affairs':
          this.menuItemIndex = 5;
          break;
        case 'Facilities':
          this.menuItemIndex = 6;
          break;
        case 'Trannsportation':
          this.menuItemIndex = 7;
          break;
        case 'Food Service':
          this.menuItemIndex = 8;
          break;
      }
    }
  }
}
</script>

<style lang="scss">
@import '../assets/main.scss';
.side-bar {
  flex: 1;
  height: calc(100vh - 50px);

  .side-bar-wrapper {
    margin: 5px;
    padding: 15px;
    border-radius: 10px;
    height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
    -webkit-box-shadow: 0px 1px 15px 1px #e6e6e6;
    box-shadow: 0px 1px 15px 1px #e6e6e6;
    gap: 35px;

    .side-bar-header {
      font-size: 20px;
      position: relative;
      width: max-content;
      &::before {
        content: "";
        position: absolute;
        bottom: -5px;
        right: 0;
        width: 50%;
        height: 3px;
        background-color: $red-color;
      }
    }

    .side-bar-lists {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 25px;

      .side-bar-list {
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;

        &.active {
          position: relative;

          &::before {
            content: "";
            z-index: -1;
            position: absolute;
            top: -10px;
            left: -15px;
            height: 100%;
            padding: 10px;
            width: calc(100% + 10px);
            background-color: $gray-color;
            border-left: 2px solid $red-color;
          }
        }
      }
    }
  }

}
</style>