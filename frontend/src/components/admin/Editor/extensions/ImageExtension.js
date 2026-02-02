import Image from "@tiptap/extension-image";
import {
  faAlignLeft,
  faAlignCenter,
  faAlignRight,
  faAlignJustify,
} from "@fortawesome/free-solid-svg-icons";

const ImageExtension = Image.extend({
  addAttributes() {
    return {
      ...this.parent?.(),
      class: {
        default: null,
        parseHTML: (element) => element.getAttribute("class"),
        renderHTML: (attributes) => {
          if (!attributes.class) {
            return {};
          }
          return {
            class: attributes.class,
          };
        },
      },
      width: {
        default: null,
        parseHTML: (element) => element.getAttribute("width"),
        renderHTML: (attributes) => {
          if (!attributes.width) {
            return {};
          }
          return {
            width: attributes.width,
          };
        },
      },
      height: {
        default: null,
        parseHTML: (element) => element.getAttribute("height"),
        renderHTML: (attributes) => {
          if (!attributes.height) {
            return {};
          }
          return {
            height: attributes.height,
          };
        },
      },
    };
  },
  addNodeView() {
    return ({ node, getPos, editor }) => {
      const container = document.createElement("div");
      container.setAttribute("data-resize-container", "true");
      container.style.position = "relative";
      container.style.display = "inline-block";
      container.style.lineHeight = "0";

      container.addEventListener("click", () => {
        if (typeof getPos === "function") {
          editor.commands.setNodeSelection(getPos());
        }
      });

      const wrapper = document.createElement("div");
      wrapper.setAttribute("data-resize-wrapper", "true");
      wrapper.style.position = "relative";
      wrapper.style.display = "inline-block";

      const img = document.createElement("img");
      img.src = node.attrs.src;

      wrapper.appendChild(img);

      const updateLayout = (className) => {
        container.className = className || "";

        if (className && className.includes("block")) {
          container.style.display = "block";
          wrapper.style.display = "inline-block";

          if (className.includes("mx-auto")) {
            container.style.textAlign = "center";
          } else {
            container.style.textAlign = "";
          }
        } else {
          container.style.display = "inline-block";
          container.style.textAlign = "";
        }
      };

      const toolbar = document.createElement("div");
      toolbar.setAttribute("data-image-toolbar", "true");
      toolbar.className =
        "absolute top-2 left-1/2 -translate-x-1/2 flex items-center gap-1 bg-white shadow-md border border-gray-200 rounded p-1 z-30 pointer-events-auto";

      const getIconSvg = (iconDef) => {
        if (!iconDef || !iconDef.icon) return "";
        const path = iconDef.icon[4];
        const width = iconDef.icon[0];
        const height = iconDef.icon[1];
        return `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${width} ${height}" fill="currentColor" style="width: 12px; height: 12px;"><path d="${path}"/></svg>`;
      };

      const iconLeft = getIconSvg(faAlignLeft);
      const iconCenter = getIconSvg(faAlignCenter);
      const iconRight = getIconSvg(faAlignRight);
      const iconBlock = getIconSvg(faAlignJustify);

      const createButton = (iconSvg, alignType) => {
        const btn = document.createElement("button");
        btn.className =
          "p-1.5 hover:bg-gray-100 rounded text-gray-600 flex items-center justify-center";
        btn.innerHTML = iconSvg;
        btn.type = "button";
        btn.title = `Align ${alignType}`;
        btn.addEventListener("mousedown", (e) => {
          e.preventDefault();
          e.stopPropagation();
          editor.chain().focus();

          let className = "";
          if (alignType === "left") className = "float-left";
          else if (alignType === "center") className = "block mx-auto";
          else if (alignType === "right") className = "float-right";
          else if (alignType === "block") className = "block";

          editor.commands.updateAttributes("image", { class: className });
        });
        return btn;
      };

      toolbar.appendChild(createButton(iconLeft, "left"));
      toolbar.appendChild(createButton(iconCenter, "center"));
      toolbar.appendChild(createButton(iconRight, "right"));
      toolbar.appendChild(createButton(iconBlock, "block"));

      wrapper.appendChild(toolbar);

      const handles = ["top-left", "top-right", "bottom-left", "bottom-right"];
      const handleElements = {};

      handles.forEach((position) => {
        const handle = document.createElement("div");
        handle.setAttribute("data-resize-handle", position);

        handle.className =
          "absolute w-3 h-3 bg-gray-800 border-2 border-white rounded-full z-20 pointer-events-auto";

        if (position === "top-left") {
          handle.classList.add(
            "top-0",
            "left-0",
            "-translate-x-1/2",
            "-translate-y-1/2",
            "cursor-nwse-resize",
          );
        } else if (position === "top-right") {
          handle.classList.add(
            "top-0",
            "right-0",
            "translate-x-1/2",
            "-translate-y-1/2",
            "cursor-nesw-resize",
          );
        } else if (position === "bottom-left") {
          handle.classList.add(
            "bottom-0",
            "left-0",
            "-translate-x-1/2",
            "translate-y-1/2",
            "cursor-nesw-resize",
          );
        } else if (position === "bottom-right") {
          handle.classList.add(
            "bottom-0",
            "right-0",
            "translate-x-1/2",
            "translate-y-1/2",
            "cursor-nwse-resize",
          );
        }

        handleElements[position] = handle;
        wrapper.appendChild(handle);
      });

      if (node.attrs.width) img.style.width = `${node.attrs.width}px`;
      if (node.attrs.height) img.style.height = `${node.attrs.height}px`;
      updateLayout(node.attrs.class);

      let isResizing = false;
      let startX, startY, startWidth, startHeight, currentHandle;

      const onMouseDown = (e, handle) => {
        e.preventDefault();
        e.stopPropagation();
        isResizing = true;
        currentHandle = handle;
        startX = e.clientX;
        startY = e.clientY;
        startWidth = img.offsetWidth;
        startHeight = img.offsetHeight;

        container.setAttribute("data-resize-state", "true");
        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
      };

      const onMouseMove = (e) => {
        if (!isResizing) return;

        const deltaX = e.clientX - startX;
        const deltaY = e.clientY - startY;
        let newWidth = startWidth;
        let newHeight = startHeight;

        let changeX = 0;
        let changeY = 0;

        if (currentHandle.includes("right")) changeX = deltaX;
        else if (currentHandle.includes("left")) changeX = -deltaX;

        if (currentHandle.includes("bottom")) changeY = deltaY;
        else if (currentHandle.includes("top")) changeY = -deltaY;

        newWidth = startWidth + changeX;
        newHeight = startHeight + changeY;

        const aspectRatio = startWidth / startHeight;

        if (Math.abs(deltaX) > Math.abs(deltaY)) {
          newHeight = newWidth / aspectRatio;
        } else {
          newWidth = newHeight * aspectRatio;
        }

        if (newWidth < 50) {
          newWidth = 50;
          newHeight = newWidth / aspectRatio;
        }
        if (newHeight < 50) {
          newHeight = 50;
          newWidth = newHeight * aspectRatio;
        }

        img.style.width = `${newWidth}px`;
        img.style.height = `${newHeight}px`;
      };

      const onMouseUp = () => {
        if (!isResizing) return;
        isResizing = false;
        container.setAttribute("data-resize-state", "false");

        const pos = getPos();
        if (pos !== undefined) {
          editor.commands.updateAttributes("image", {
            width: Math.round(img.offsetWidth),
            height: Math.round(img.offsetHeight),
          });
        }

        document.removeEventListener("mousemove", onMouseMove);
        document.removeEventListener("mouseup", onMouseUp);
      };

      Object.entries(handleElements).forEach(([position, handle]) => {
        handle.addEventListener("mousedown", (e) => onMouseDown(e, position));
      });

      container.appendChild(wrapper);

      return {
        dom: container,
        update: (updatedNode) => {
          if (updatedNode.type !== node.type) return false;

          if (updatedNode.attrs.src !== node.attrs.src) {
            img.src = updatedNode.attrs.src;
          }

          updateLayout(updatedNode.attrs.class);

          if (updatedNode.attrs.width) {
            img.style.width = `${updatedNode.attrs.width}px`;
          }
          if (updatedNode.attrs.height) {
            img.style.height = `${updatedNode.attrs.height}px`;
          }

          return true;
        },
        destroy: () => {
          document.removeEventListener("mousemove", onMouseMove);
          document.removeEventListener("mouseup", onMouseUp);
        },
      };
    };
  },
});

export default ImageExtension;
