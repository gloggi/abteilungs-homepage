<template>
  <div
    v-if="editor"
    class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50/50 p-1"
  >
    <EditorButton
      @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
      :active="editor.isActive('heading', { level: 2 })"
    >
      <font-awesome-icon class="size-4" :icon="icons.faHeading" />
      <span class="text-xs font-bold ml-0.5">2</span>
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
      :active="editor.isActive('heading', { level: 3 })"
    >
      <font-awesome-icon class="size-4" :icon="icons.faHeading" />
      <span class="text-xs font-bold ml-0.5">3</span>
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="editor.chain().focus().toggleBold().run()"
      :active="editor.isActive('bold')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faBold" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleItalic().run()"
      :active="editor.isActive('italic')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faItalic" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleUnderline().run()"
      :active="editor.isActive('underline')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faUnderline" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleStrike().run()"
      :active="editor.isActive('strike')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faStrikethrough" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton @click.self.prevent>
      <EditorColorPicker v-model="computedTextColor" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="editor.chain().focus().toggleBulletList().run()"
      :active="editor.isActive('bulletList')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faList" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleOrderedList().run()"
      :active="editor.isActive('orderedList')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faListOl" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton @click="$emit('add-image')">
      <font-awesome-icon class="size-4" :icon="icons.faImage" />
    </EditorButton>
    <EditorButton
      v-if="!editor.isActive('link')"
      @click="$emit('ask-for-link')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faLink" />
    </EditorButton>
    <EditorButton
      v-else
      @click="editor.chain().focus().unsetLink().run()"
      :active="true"
    >
      <font-awesome-icon class="size-4" :icon="icons.faLinkSlash" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <div class="relative" ref="tableDropdown">
      <EditorButton
        @click="toggleTableDropdown"
        :active="editor.isActive('table')"
        :title="$t('dashboard.editor.table')"
      >
        <font-awesome-icon class="size-4" :icon="icons.faTable" />
      </EditorButton>
      <div
        v-if="showTableDropdown"
        class="absolute left-0 top-full mt-1 z-50 bg-white border border-gray-200 rounded-lg shadow-lg p-2 min-w-[220px]"
      >
        <button
          v-if="!editor.isActive('table')"
          @click="insertTable"
          class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
        >
          <font-awesome-icon :icon="icons.faTableCellsLarge" class="w-4 h-4" />
          <span>{{ $t("dashboard.editor.insertTable") }}</span>
        </button>

        <div v-if="!editor.isActive('table')" class="px-3 py-2">
          <div class="text-xs text-gray-500 mb-2">
            {{ $t("dashboard.editor.selectSize") }}
          </div>
          <div class="grid grid-cols-5 gap-1">
            <template v-for="row in 5" :key="'row-' + row">
              <button
                v-for="col in 5"
                :key="'cell-' + row + '-' + col"
                @mouseenter="hoverGrid(row, col)"
                @click="insertTableWithSize(row, col)"
                :class="[
                  'w-5 h-5 border rounded-sm transition-colors',
                  row <= gridHover.rows && col <= gridHover.cols
                    ? 'bg-primary border-primary'
                    : 'bg-gray-100 border-gray-300 hover:bg-gray-200',
                ]"
              ></button>
            </template>
          </div>
          <div class="text-xs text-gray-500 mt-2 text-center">
            {{ gridHover.rows }} × {{ gridHover.cols }}
          </div>
        </div>

        <template v-if="editor.isActive('table')">
          <div class="text-xs font-medium text-gray-500 px-3 py-1">
            {{ $t("dashboard.editor.rows") }}
          </div>
          <button
            @click="
              editor.chain().focus().addRowBefore().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faArrowUp" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.addRowBefore") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().addRowAfter().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faArrowDown" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.addRowAfter") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().deleteRow().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faTrash" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.deleteRow") }}</span>
          </button>

          <div class="h-px bg-gray-200 my-2"></div>
          <div class="text-xs font-medium text-gray-500 px-3 py-1">
            {{ $t("dashboard.editor.columns") }}
          </div>
          <button
            @click="
              editor.chain().focus().addColumnBefore().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faArrowLeft" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.addColumnBefore") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().addColumnAfter().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faArrowRight" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.addColumnAfter") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().deleteColumn().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faTrash" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.deleteColumn") }}</span>
          </button>

          <div class="h-px bg-gray-200 my-2"></div>
          <div class="text-xs font-medium text-gray-500 px-3 py-1">
            {{ $t("dashboard.editor.cells") }}
          </div>
          <button
            @click="
              editor.chain().focus().mergeCells().run();
              closeTableDropdown();
            "
            :disabled="!editor.can().mergeCells()"
            :class="[
              'w-full flex items-center gap-2 px-3 py-2 text-sm rounded-md transition-colors',
              editor.can().mergeCells()
                ? 'text-gray-700 hover:bg-gray-100'
                : 'text-gray-400 cursor-not-allowed',
            ]"
          >
            <font-awesome-icon :icon="icons.faLayerGroup" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.mergeCells") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().splitCell().run();
              closeTableDropdown();
            "
            :disabled="!editor.can().splitCell()"
            :class="[
              'w-full flex items-center gap-2 px-3 py-2 text-sm rounded-md transition-colors',
              editor.can().splitCell()
                ? 'text-gray-700 hover:bg-gray-100'
                : 'text-gray-400 cursor-not-allowed',
            ]"
          >
            <font-awesome-icon :icon="icons.faClone" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.splitCell") }}</span>
          </button>

          <div class="h-px bg-gray-200 my-2"></div>
          <div class="text-xs font-medium text-gray-500 px-3 py-1">
            {{ $t("dashboard.editor.headers") }}
          </div>
          <button
            @click="
              editor.chain().focus().toggleHeaderRow().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faGripLines" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.toggleHeaderRow") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().toggleHeaderColumn().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon
              :icon="icons.faGripLinesVertical"
              class="w-4 h-4"
            />
            <span>{{ $t("dashboard.editor.toggleHeaderColumn") }}</span>
          </button>
          <button
            @click="
              editor.chain().focus().toggleHeaderCell().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faTh" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.toggleHeaderCell") }}</span>
          </button>

          <div class="h-px bg-gray-200 my-2"></div>
          <button
            @click="
              editor.chain().focus().deleteTable().run();
              closeTableDropdown();
            "
            class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors"
          >
            <font-awesome-icon :icon="icons.faTrash" class="w-4 h-4" />
            <span>{{ $t("dashboard.editor.deleteTable") }}</span>
          </button>
        </template>
      </div>
    </div>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="handleAlign('left', 'float-left')"
      :active="
        editor.isActive({ textAlign: 'left' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'float-left')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignLeft" />
    </EditorButton>
    <EditorButton
      @click="handleAlign('center', 'block mx-auto')"
      :active="
        editor.isActive({ textAlign: 'center' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'block mx-auto')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignCenter" />
    </EditorButton>
    <EditorButton
      @click="handleAlign('right', 'float-right')"
      :active="
        editor.isActive({ textAlign: 'right' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'float-right')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignRight" />
    </EditorButton>

    <div class="ml-auto flex items-center gap-1">
      <EditorButton @click="editor.chain().focus().undo().run()">
        <font-awesome-icon class="size-4" :icon="icons.faArrowRotateLeft" />
      </EditorButton>
      <EditorButton @click="editor.chain().focus().redo().run()">
        <font-awesome-icon class="size-4" :icon="icons.faArrowRotateRight" />
      </EditorButton>
      <div class="h-4 w-px bg-gray-200 mx-1"></div>
      <EditorButton @click="$emit('swap-editor-content')" :active="showHTML">
        <font-awesome-icon class="size-4" :icon="icons.faCode" />
      </EditorButton>
    </div>
  </div>
</template>

<script>
import EditorButton from "./EditorButton.vue";
import EditorColorPicker from "./EditorColorPicker.vue";
import {
  faArrowRotateLeft,
  faArrowRotateRight,
  faList,
  faListOl,
  faCode,
  faLink,
  faLinkSlash,
  faImage,
  faHeading,
  faAlignRight,
  faAlignLeft,
  faAlignCenter,
  faBold,
  faItalic,
  faStrikethrough,
  faUnderline,
  faTable,
  faTableCellsLarge,
  faGripLines,
  faGripLinesVertical,
  faArrowUp,
  faArrowDown,
  faArrowLeft,
  faArrowRight,
  faTrash,
  faLayerGroup,
  faClone,
  faTh,
} from "@fortawesome/free-solid-svg-icons";

export default {
  props: {
    editor: {
      type: Object,
      required: true,
    },
    showHTML: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    EditorButton,
    EditorColorPicker,
  },
  emits: ["add-image", "ask-for-link", "swap-editor-content"],
  data() {
    return {
      showTableDropdown: false,
      gridHover: { rows: 3, cols: 3 },
      icons: {
        faArrowRotateLeft,
        faArrowRotateRight,
        faList,
        faListOl,
        faCode,
        faLink,
        faLinkSlash,
        faImage,
        faHeading,
        faAlignRight,
        faAlignLeft,
        faAlignCenter,
        faBold,
        faItalic,
        faStrikethrough,
        faUnderline,
        faTable,
        faTableCellsLarge,
        faGripLines,
        faGripLinesVertical,
        faArrowUp,
        faArrowDown,
        faArrowLeft,
        faArrowRight,
        faTrash,
        faLayerGroup,
        faClone,
        faTh,
      },
    };
  },
  computed: {
    computedTextColor: {
      get() {
        return this.editor.getAttributes("textStyle").color
          ? this.editor.getAttributes("textStyle").color
          : "#333333";
      },
      set(value) {
        this.editor.chain().focus().setColor(value).run();
      },
    },
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  methods: {
    handleClickOutside(event) {
      if (
        this.$refs.tableDropdown &&
        !this.$refs.tableDropdown.contains(event.target)
      ) {
        this.showTableDropdown = false;
      }
    },
    toggleTableDropdown() {
      this.showTableDropdown = !this.showTableDropdown;
    },
    closeTableDropdown() {
      this.showTableDropdown = false;
    },
    hoverGrid(rows, cols) {
      this.gridHover = { rows, cols };
    },
    insertTable() {
      this.editor
        .chain()
        .focus()
        .insertTable({ rows: 3, cols: 3, withHeaderRow: true })
        .run();
      this.closeTableDropdown();
    },
    insertTableWithSize(rows, cols) {
      this.editor
        .chain()
        .focus()
        .insertTable({ rows, cols, withHeaderRow: true })
        .run();
      this.closeTableDropdown();
    },
    handleAlign(text, imageClass) {
      this.editor.chain().focus();
      if (this.editor.isActive("image")) {
        this.editor
          .chain()
          .updateAttributes("image", { class: imageClass })
          .run();
      } else {
        this.editor.chain().setTextAlign(text).run();
      }
    },
  },
};
</script>
