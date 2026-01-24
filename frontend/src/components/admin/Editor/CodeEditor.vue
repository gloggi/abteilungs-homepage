<template>
  <div
    ref="cmContainer"
    class="w-full h-full min-h-[12rem] font-mono text-sm overflow-hidden"
  ></div>
</template>

<script>
import { EditorState } from "@codemirror/state";
import {
  EditorView,
  keymap,
  lineNumbers,
  highlightActiveLine,
  highlightActiveLineGutter,
} from "@codemirror/view";
import { defaultKeymap, history, historyKeymap } from "@codemirror/commands";
import { html } from "@codemirror/lang-html";
import { oneDark } from "@codemirror/theme-one-dark";
import {
  syntaxHighlighting,
  defaultHighlightStyle,
  bracketMatching,
  foldKeymap,
} from "@codemirror/language";
import jsBeautify from "js-beautify";

export default {
  props: ["modelValue"],
  data() {
    return {
      cmEditor: null,
    };
  },
  mounted() {
    const formattedHTML = jsBeautify.html(this.modelValue || "", {
      indent_size: 2,
      wrap_line_length: 0,
      preserve_newlines: true,
    });

    const startState = EditorState.create({
      doc: formattedHTML,
      extensions: [
        keymap.of([...defaultKeymap, ...historyKeymap, ...foldKeymap]),
        history(),
        lineNumbers(),
        highlightActiveLine(),
        highlightActiveLineGutter(),
        bracketMatching(),
        html(),
        oneDark,
        EditorView.lineWrapping,
        syntaxHighlighting(defaultHighlightStyle),
        EditorView.updateListener.of((update) => {
          if (update.docChanged) {
            this.$emit("update:modelValue", update.state.doc.toString());
          }
        }),
      ],
    });

    this.cmEditor = new EditorView({
      state: startState,
      parent: this.$refs.cmContainer,
    });
    
    this.$emit("update:modelValue", formattedHTML);
  },
  beforeUnmount() {
    if (this.cmEditor) {
      this.cmEditor.destroy();
    }
  },
  watch: {
    modelValue(value) {
      if (this.cmEditor && value !== this.cmEditor.state.doc.toString()) {
        const currentPos = this.cmEditor.state.selection.main.head;
        this.cmEditor.dispatch({
          changes: {
            from: 0,
            to: this.cmEditor.state.doc.length,
            insert: value,
          },
          selection: { anchor: currentPos },
        });
      }
    },
  },
};
</script>
