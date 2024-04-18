<template>
  <div class="rounded-lg pt-2">
    <div v-if="editor" class="flex justify-between">
      <div class="flex flex-col">
        <div class="flex flex-row flex-wrap items-startspace-y-1 gap-3">
          <div class="flex">
            <EditorButton
              @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
              :active="editor.isActive('heading', { level: 2 })"
              class="rounded-l-lg border-l whitespace-nowrap"
            >
              <font-awesome-icon class="size-4" :icon="icons.faHeading" /><sub
                class="font-bold"
                >2</sub
              >
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
              :active="editor.isActive('heading', { level: 3 })"
              class="rounded-r-lg whitespace-nowrap"
            >
              <font-awesome-icon class="size-4" :icon="icons.faHeading" /><sub
                class="font-bold"
                >3</sub
              >
            </EditorButton>
          </div>
          <div class="flex">
            <EditorButton
              @click="editor.chain().focus().toggleBold().run()"
              :active="editor.isActive('bold')"
              class="rounded-l-lg border-l"
            >
              <font-awesome-icon class="size-5" :icon="icons.faBold" />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleItalic().run()"
              :active="editor.isActive('italic')"
            >
              <font-awesome-icon class="size-5" :icon="icons.faItalic" />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleUnderline().run()"
              :active="editor.isActive('underline')"
            >
              <font-awesome-icon class="size-5" :icon="icons.faUnderline" />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleStrike().run()"
              :active="editor.isActive('strike')"
            >
              <font-awesome-icon class="size-5" :icon="icons.faStrikethrough" />
            </EditorButton>
            <EditorButton @click.self.prevent class="rounded-r-lg">
              <EditorColorPicker v-model="textColor" />
            </EditorButton>
          </div>
          <div class="flex">
            <EditorButton
              @click="editor.chain().focus().toggleBulletList().run()"
              :active="editor.isActive('bulletList')"
              class="rounded-l-lg border-l"
            >
              <font-awesome-icon class="size-5" :icon="icons.faList" />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleOrderedList().run()"
              :active="editor.isActive('orderedList')"
              class="rounded-r-lg"
            >
              <font-awesome-icon class="size-5" :icon="icons.faListOl" />
            </EditorButton>
          </div>
          <div class="flex">
            <EditorButton @click="addImage" class="rounded-l-lg border-l">
              <font-awesome-icon class="size-5" :icon="icons.faImage" />
            </EditorButton>
            <EditorButton
              v-if="!editor.isActive('link')"
              @click="askForLink"
              class="rounded-r-lg"
            >
              <font-awesome-icon class="size-5" :icon="icons.faLink" />
            </EditorButton>
            <EditorButton
              v-if="editor.isActive('link')"
              @click="editor.chain().focus().unsetLink().run()"
              class="rounded-r-lg"
            >
              <font-awesome-icon class="size-5" :icon="icons.faLinkSlash" />
            </EditorButton>
          </div>
          <div class="flex">
            <EditorButton
              @click="handleAlign('left', 'float-left')"
              :active="
                editor.isActive({ textAlign: 'left' }) ||
                (editor.isActive('image') &&
                  editor.getAttributes('image').class === 'float-left')
              "
              class="rounded-l-lg border-l"
            >
              <font-awesome-icon class="size-5" :icon="icons.faAlignLeft" />
            </EditorButton>

            <EditorButton
              @click="handleAlign('center', 'block mx-auto')"
              :active="
                editor.isActive({ textAlign: 'center' }) ||
                (editor.isActive('image') &&
                  editor.getAttributes('image').class === 'block mx-auto')
              "
            >
              <font-awesome-icon class="size-5" :icon="icons.faAlignCenter" />
            </EditorButton>
            <EditorButton
              @click="handleAlign('right', 'float-right')"
              :active="
                editor.isActive({ textAlign: 'right' }) ||
                (editor.isActive('image') &&
                  editor.getAttributes('image').class === 'float-right')
              "
              class="rounded-r-lg"
            >
              <font-awesome-icon class="size-5" :icon="icons.faAlignRight" />
            </EditorButton>
          </div>
          <EditorButton
            @click="swapEditorContent"
            :active="showHTML"
            class="rounded-lg border-l"
          >
            <font-awesome-icon class="size-5" :icon="icons.faCode" />
          </EditorButton>
          <div class="flex">
            <EditorButton
              @click="editor.chain().focus().undo().run()"
              class="rounded-l-lg border-l"
            >
              <font-awesome-icon
                class="size-5"
                :icon="icons.faArrowRotateLeft"
              />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().redo().run()"
              class="rounded-r-lg"
            >
              <font-awesome-icon
                class="size-5"
                :icon="icons.faArrowRotateRight"
              />
            </EditorButton>
          </div>
        </div>
      </div>
    </div>
    <editor-content v-if="!showHTML" :editor="editor" />
    <textarea
      v-else
      v-model="inputModel"
      class="appearance-none w-full prose prose-sm sm:prose lg:prose-lg xl:prose-2xl my-2 focus:outline-none bg-white rounded-lg p-2 h-48 overflow-scroll font-mono focus:ring-0 border border-gray-700 focus:border-gray-700"
    >
    </textarea>
  </div>
  <MediaModal
    v-if="showMediaModal"
    @close="showMediaModal = false"
    @select="handleSelect"
    :max-select="1"
    :extensions="['jpg', 'jpeg', 'png', 'gif', 'svg']"
  />
  <Modal v-if="showLinkModal" @close="showLinkModal = false">
    <form @submit.prevent="setLink" class="p-3 flex space-x-2 items-end">
      <TextInput
        class="w-full"
        v-model="newLink"
        :required="true"
        :label="$t('dashboard.link')"
        type="url"
        placeholder="https://"
      />
      <ActionButton :reverse="true" type="submit">
        <font-awesome-icon class="h-6 w-6" :icon="icons.faLink" />
      </ActionButton>
    </form>
  </Modal>
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import HeadingExtension from "@tiptap/extension-heading";
import Image from "@tiptap/extension-image";
import LinkExtension from "@tiptap/extension-link";
import { Color } from "@tiptap/extension-color";
import TextStyle from "@tiptap/extension-text-style";
import TextAlign from "@tiptap/extension-text-align";
import { mergeAttributes } from "@tiptap/core";
import Placeholder from "@tiptap/extension-placeholder";
import Table from "@tiptap/extension-table";
import TableCell from "@tiptap/extension-table-cell";
import TableHeader from "@tiptap/extension-table-header";
import TableRow from "@tiptap/extension-table-row";
import Underline from "@tiptap/extension-underline";
import Resizable from "./resizable-image";
import EditorButton from "./EditorButton.vue";
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
  faFont,
  faUnderline,
} from "@fortawesome/free-solid-svg-icons";
import MediaModal from "../MediaModal.vue";
import Modal from "../Modal.vue";
import TextInput from "../TextInput.vue";
import ActionButton from "../ActionButton.vue";
import EditorColorPicker from "./EditorColorPicker.vue";
export default {
  props: ["modelValue", "placeholder"],
  components: {
    EditorContent,
    EditorButton,
    MediaModal,
    Modal,
    TextInput,
    ActionButton,
    EditorColorPicker,
  },
  data() {
    return {
      editor: null,
      showHTML: false,
      showMediaModal: false,
      showLinkModal: false,
      newLink: undefined,
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
        faFont,
        faUnderline,
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
      this.showLinkModal = true;
    },
    setLink() {
      this.showLinkModal = false;
      const previousUrl = this.editor.getAttributes("link").href;
      const url = this.newLink;

      if (url === null) {
        return;
      }

      if (url === "") {
        this.editor.chain().focus().extendMarkRange("link").unsetLink().run();

        return;
      }

      this.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: url })
        .run();
    },
    handleSelect(selected) {
      this.editor
        .chain()
        .focus()
        .setImage({ src: this.backendURL + selected[0].path })
        .run();
    },
    handleAlign(text, imageClass) {
      this.editor.chain().focus();
      if (this.editor.isActive("image")) {
        console.log("image");
        this.editor
          .chain()
          .updateAttributes("image", { class: imageClass })
          .run();
      } else {
        console.log("text");
        this.editor.chain().setTextAlign(text).run();
      }
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
    textColor: {
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
    this.editor = new Editor({
      content: this.inputModel,
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
            class: "link hover:text-secondary",
            target: "_self",
          },
        }),
        TextStyle,
        Color,
        Image.configure({
          inline: true,
        }),

        Resizable.configure({
          types: ["image", "video"],
          handlerStyle: {
            // handler point style
            width: "8px",
            height: "8px",
            background: "#111827",
          },
          layerStyle: {
            border: "2px dashed #111827",
          },
        }),
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
            "prose prose-sm sm:prose lg:prose-lg xl:prose-2xl my-2 focus:outline-none bg-white rounded-lg p-2 min-h-[12rem] overflow-scroll border border-gray-700",
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
</style>
