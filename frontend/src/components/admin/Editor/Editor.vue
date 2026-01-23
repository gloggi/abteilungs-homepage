<template>
  <div class="flex flex-col gap-2">
    <FormLabel :for="id">{{ label }}</FormLabel>
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
        <textarea
          v-else
          v-model="inputModel"
          class="w-full h-full min-h-[12rem] p-4 font-mono text-sm focus:outline-none resize-none"
        ></textarea>
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
// ... imports
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
import ImageExtension from "./extensions/ImageExtension";
import {
  faLink,
  faUnlink,
  faExternalLinkAlt,
} from "@fortawesome/free-solid-svg-icons"; // Added faUnlink
import MediaModal from "../MediaModal.vue";
import Modal from "../Modal.vue";
import TextInput from "../TextInput.vue";
import ActionButton from "../ActionButton.vue";
import FormLabel from "../FormLabel.vue";

export default {
  props: ["modelValue", "placeholder", "id", "label"],
  components: {
    EditorContent,
    BubbleMenu, // Added BubbleMenu
    EditorToolbar,
    MediaModal,
    Modal,
    TextInput,
    ActionButton,
    FormLabel,
  },
  data() {
    return {
      editor: null,
      showHTML: false,
      showMediaModal: false,
      // Removed showLinkModal
      linkUrl: "", // Added linkUrl
      icons: {
        faLink,
        faUnlink, // Added faUnlink
        faExternalLinkAlt,
      },
    };
  },
  methods: {
    swapEditorContent() {
      this.showHTML = !this.showHTML;
    },
    addImage() {
      this.showMediaModal = true;
    },
    askForLink() {
      const previousUrl = this.editor.getAttributes("link").href;

      // If already a link, likely want to edit it, so we ensure the menu is visible or focus it.
      // But if we want to toggle, we might interpret a click as "unset".
      // Standard behavior: if selection has logic, we toggle.
      if (previousUrl) {
        this.editor.chain().focus().extendMarkRange("link").unsetLink().run();
        return;
      }

      // If not a link, set it to empty string to trigger the bubble menu detection
      this.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: "" })
        .run();
    },
    // Removed setLink
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
    // Removed onBubbleMenuUpdate as it is handled by onSelectionUpdate
    shouldShowBubbleMenu({ editor }) {
      return editor.isActive("link");
    },
  },
  watch: {
    modelValue(value) {
      const isSame = this.editor.getHTML() === value;
      if (isSame) {
        return;
      }
      this.editor.commands.setContent(value, false);
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
        HeadingExtension.configure({ levels: [1, 2] }).extend({
          levels: [1, 2],
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

/* Tiptap Image Resize Styles */
.ProseMirror img {
  display: block;
  max-width: 100%;
  height: auto;
}

/* ResizableNodeView container */
.ProseMirror [data-resize-container] {
  position: relative;
  display: inline-block;
  line-height: 0;
}

/* ResizableNodeView wrapper */
.ProseMirror [data-resize-wrapper] {
  position: relative;
  display: inline-block;
}

/* When node is selected */
.ProseMirror .ProseMirror-selectednode [data-resize-wrapper],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-wrapper] {
  outline: 2px solid var(--primary-color);
  outline-offset: 2px;
}

/* Resize handles - hidden by default */
.ProseMirror [data-resize-handle],
.ProseMirror [data-image-toolbar] {
  display: none;
}

/* Show handles and toolbar when selected */
.ProseMirror .ProseMirror-selectednode [data-resize-handle],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-handle],
.ProseMirror .ProseMirror-selectednode [data-image-toolbar],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-image-toolbar] {
  display: flex !important; /* Force flex for toolbar, block is fine for handles but handles are div so flex ok? check */
}

/* Specific fix for handles which are divs and might need block/default */
.ProseMirror .ProseMirror-selectednode [data-resize-handle],
.ProseMirror
  [data-resize-container].ProseMirror-selectednode
  [data-resize-handle] {
  display: block !important;
}
</style>
