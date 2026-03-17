<template>
  <div class="flex flex-col gap-2">
    <FormLabel :label-for="id">{{ label }}</FormLabel>
    <div
      class="rounded-md border border-gray-200 bg-white shadow-sm overflow-hidden"
    >
      <EditorToolbar
        v-if="editor"
        :editor="editor"
        :showHTML="showHTML"
        @add-image="addImage"
        @ask-for-link="askForLink"
        @swap-editor-content="swapEditorContent"
      />
      <div class="relative min-h-[12rem]">
        <editor-content v-if="!showHTML" :editor="editor" class="p-4" />
        <CodeEditor
          v-else
          v-model="editorContent"
          class="w-full h-full min-h-[12rem]"
        />
      </div>
    </div>
  </div>
  <MediaModal
    v-if="showMediaModal"
    @close="showMediaModal = false"
    @select="handleSelect"
    :max-select="1"
    :extensions="['jpg', 'jpeg', 'png', 'gif', 'svg']"
  />
  <bubble-menu
    v-if="editor"
    :editor="editor"
    :tippy-options="{ duration: 100, placement: 'bottom' }"
    :should-show="shouldShowBubbleMenu"
  >
    <div
      class="bg-white border border-gray-200 rounded-lg shadow-lg flex p-2 gap-2 items-center"
    >
      <input
        type="url"
        v-model="linkUrl"
        class="border border-gray-300 rounded px-2 py-1 text-sm text-gray-700 outline-none w-48 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
        placeholder="https://..."
        @keydown.enter.prevent="updateLink"
        @blur="updateLink"
      />
      <button
        @click="updateLink"
        class="text-gray-500 hover:text-green-600 transition-colors p-1 rounded hover:bg-gray-100"
        type="button"
        title="Apply Link"
      >
        <font-awesome-icon :icon="icons.faLink" class="w-4 h-4" />
      </button>
      <a
        v-if="linkUrl"
        :href="linkUrl"
        target="_blank"
        rel="noopener noreferrer"
        class="text-gray-500 hover:text-blue-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center"
        :title="$t('dashboard.openLink')"
      >
        <font-awesome-icon :icon="icons.faExternalLinkAlt" class="w-4 h-4" />
      </a>
      <button
        @click="removeLink"
        class="text-gray-500 hover:text-red-600 transition-colors p-1 rounded hover:bg-gray-100"
        type="button"
        title="Unlink"
      >
        <font-awesome-icon :icon="icons.faUnlink" class="w-4 h-4" />
      </button>
    </div>
  </bubble-menu>
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-3";
import { BubbleMenu } from "@tiptap/vue-3/menus";
import { StarterKit } from "@tiptap/starter-kit";
import { Heading as HeadingExtension } from "@tiptap/extension-heading";
import { Link as LinkExtension } from "@tiptap/extension-link";
import { Color } from "@tiptap/extension-color";
import { TextStyle } from "@tiptap/extension-text-style";
import { TextAlign } from "@tiptap/extension-text-align";
import { mergeAttributes } from "@tiptap/core";
import { Placeholder } from "@tiptap/extension-placeholder";
import { Table } from "@tiptap/extension-table";
import { TableCell } from "@tiptap/extension-table-cell";
import { TableHeader } from "@tiptap/extension-table-header";
import { TableRow } from "@tiptap/extension-table-row";
import { Underline } from "@tiptap/extension-underline";

import EditorToolbar from "./EditorToolbar.vue";
import CodeEditor from "./CodeEditor.vue";
import ImageExtension from "./extensions/ImageExtension";
import {
  faLink,
  faUnlink,
  faExternalLinkAlt,
} from "@fortawesome/free-solid-svg-icons";
import MediaModal from "../MediaModal.vue";

import FormLabel from "../FormLabel.vue";

export default {
  props: ["modelValue", "placeholder", "id", "label"],
  components: {
    EditorContent,
    BubbleMenu,
    EditorToolbar,
    MediaModal,
    CodeEditor,
    FormLabel,
  },
  data() {
    return {
      editor: null,
      showHTML: false,
      showMediaModal: false,
      editorContent: "",

      linkUrl: "",
      icons: {
        faLink,
        faUnlink,
        faExternalLinkAlt,
      },
    };
  },
  methods: {
    swapEditorContent() {
      if (this.showHTML) {
        this.editor.commands.setContent(this.editorContent);
        this.showHTML = false;
      } else {
        this.editorContent = this.editor.getHTML();
        this.showHTML = true;
      }
    },
    addImage() {
      this.showMediaModal = true;
    },
    askForLink() {
      const previousUrl = this.editor.getAttributes("link").href;

      if (previousUrl) {
        this.editor.chain().focus().extendMarkRange("link").unsetLink().run();
        return;
      }

      this.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: "" })
        .run();
    },

    updateLink() {
      if (this.linkUrl === "") {
        this.editor.chain().focus().extendMarkRange("link").unsetLink().run();
        return;
      }

      this.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: this.linkUrl })
        .run();
    },
    removeLink() {
      this.editor.chain().focus().extendMarkRange("link").unsetLink().run();
    },
    handleSelect(selected) {
      this.editor
        .chain()
        .focus()
        .setImage({ src: this.backendURL + selected[0].path })
        .run();
    },

    shouldShowBubbleMenu({ editor }) {
      return editor.isActive("link");
    },
  },
  watch: {
    modelValue(value) {
      if (this.showHTML) {
        this.editorContent = value;
        return;
      }
      const isSame = this.editor.getHTML() === value;
      if (isSame) {
        return;
      }
      this.editor.commands.setContent(value, false);
    },
    editorContent(value) {
      this.$emit("update:modelValue", value);
    },
  },
  computed: {
    inputModel: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
  mounted() {
    this.editor = new Editor({
      content: this.inputModel,
      onSelectionUpdate: ({ editor }) => {
        if (editor.isActive("link")) {
          this.linkUrl = editor.getAttributes("link").href;
        } else {
          this.linkUrl = "";
        }
      },
      onBlur: () => {
        if (this.editor.isEmpty) {
          this.$emit("update:modelValue", null);
        } else {
          this.$emit("update:modelValue", this.editor.getHTML());
        }
      },
      extensions: [
        StarterKit.configure({
          paragraph: {
            HTMLAttributes: {
              class: "main-text",
            },
          },
          bulletList: {
            HTMLAttributes: {
              class: "list-disc pl-6 main-text",
            },
          },
          orderedList: {
            HTMLAttributes: {
              class: "list-decimal pl-6 main-text",
            },
          },
          heading: false,
          hardBreak: {
            addKeyboardShortcuts() {
              return {
                Enter: () => this.editor.commands.setHardBreak(),
              };
            },
          },
        }),
        HeadingExtension.configure({ levels: [1, 2, 3] }).extend({
          levels: [1, 2, 3],
          renderHTML({ node, HTMLAttributes }) {
            const level = this.options.levels.includes(node.attrs.level)
              ? node.attrs.level
              : this.options.levels[0];
            const classes = {
              2: "text-3xl mt-19 mb-5 sm:text-5xl text-heading-2 text-primary mt-4 mb-2",
              3: "text-2xl md:text-3xl pb-2 text-heading-3 text-primary mt-4 mb-2",
            };
            return [
              `h${level}`,
              mergeAttributes(this.options.HTMLAttributes, HTMLAttributes, {
                class: `${classes[level]}`,
              }),
              0,
            ];
          },
        }),
        LinkExtension.configure({
          openOnClick: false,
          HTMLAttributes: {
            class: "link",
            target: "_self",
          },
        }),
        TextStyle,
        Color,
        ImageExtension,
        TextAlign.configure({
          types: ["heading", "paragraph"],
        }),
        Placeholder.configure({
          placeholder: this.placeholder,
        }),
        Table.configure({
          resizable: true,
          HTMLAttributes: {
            class: "main-text w-full",
          },
        }),
        TableRow,
        TableHeader,
        TableCell,
        Underline.configure({
          HTMLAttributes: {
            class: "underline",
          },
        }),
      ],
      editorProps: {
        attributes: {
          class:
            "prose prose-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none min-h-[12rem]",
          id: this.id,
        },
        handleClick: (view, pos, event) => {
          if (event.target.closest("a")) {
            event.preventDefault();
            return true;
          }
          return false;
        },
      },
    });
  },
  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>
<style>
.ProseMirror p.is-editor-empty:first-child::before {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}

.ProseMirror img {
  display: block;
  max-width: 100%;
  height: auto;
}

.ProseMirror [data-resize-container] {
  position: relative;
  display: inline-block;
  line-height: 0;
}

.ProseMirror [data-resize-wrapper] {
  position: relative;
  display: inline-block;
}

.ProseMirror .ProseMirror-selectednode [data-resize-wrapper],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-wrapper] {
  outline: 2px solid var(--primary-color);
  outline-offset: 2px;
}

.ProseMirror [data-resize-handle],
.ProseMirror [data-image-toolbar] {
  display: none;
}

.ProseMirror .ProseMirror-selectednode [data-resize-handle],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-handle],
.ProseMirror .ProseMirror-selectednode [data-image-toolbar],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-image-toolbar] {
  display: flex !important;
}

.ProseMirror .ProseMirror-selectednode [data-resize-handle],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-handle] {
  display: block !important;
}

.ProseMirror table {
  border-collapse: collapse;
  margin: 1rem 0;
  overflow: hidden;
  table-layout: fixed;
  width: 100%;
}

.ProseMirror table td,
.ProseMirror table th {
  border: 1px solid var(--primary-color);
  box-sizing: border-box;
  min-width: 1em;
  padding: 0.5rem 0.75rem;
  position: relative;
  vertical-align: top;
}

.ProseMirror table td > *,
.ProseMirror table th > * {
  margin-bottom: 0;
}

.ProseMirror table th {
  font-weight: 600;
  text-align: left;
}

.ProseMirror table .selectedCell:after {
  background: rgba(var(--primary-color-rgb, 59, 130, 246), 0.15);
  content: "";
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  pointer-events: none;
  position: absolute;
  z-index: 2;
}

.ProseMirror table .column-resize-handle {
  background-color: var(--primary-color, #3b82f6);
  bottom: -2px;
  pointer-events: none;
  position: absolute;
  right: -2px;
  top: 0;
  width: 4px;
}

.ProseMirror.resize-cursor {
  cursor: col-resize;
}

/* Table row header styling */
.ProseMirror table tr:first-child th {
  border-top: 2px solid var(--primary-color);
}

.ProseMirror table tr th:first-child {
  border-left: 2px solid var(--primary-color);
}

.ProseMirror table tr:last-child td,
.ProseMirror table tr:last-child th {
  border-bottom: 2px solid var(--primary-color);
}

.ProseMirror table tr td:last-child,
.ProseMirror table tr th:last-child {
  border-right: 2px solid var(--primary-color);
}

.ProseMirror table td:hover,
.ProseMirror table th:hover {
  background-color: rgba(0, 0, 0, 0.02);
}
</style>
