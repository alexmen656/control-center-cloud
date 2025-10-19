# Control Cloud

<div align="center">

[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat&logo=vue.js&logoColor=white)](https://vuejs.org/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.x-3178C6?style=flat&logo=typescript&logoColor=white)](https://www.typescriptlang.org/)
[![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=flat&logo=vite&logoColor=white)](https://vitejs.dev/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)

</div>

---

## Dem Video
**Here:** [YouTube](https://youtu.be/mqqAAVsE3Og)

## About

Control Cloud is a modern cloud platform similar to Google Drive or iCloud, with a design inspired by Google Drive.

## Special Features

- **Sharing:** You can share files with other Control Cloud users.
- **Multiple drives:** You can create up to 3 drives, each with 1GB of storage.
- **Google Login:** You can quickly log in or register with Google.
- **Drag & Drop upload:** You can simply drag files anywhere onto the dashboard to upload them.

---

## Getting Started

### Prerequisites

- **Node.js** 18.x or higher
- **npm** 9.x or higher

### Installation

1. **Clone the repository**

   ```sh
   git clone https://github.com/alexmen656/control-center-cloud.git
   cd control-center-cloud
   ```

2. **Install dependencies**

   ```sh
   npm install
   ```

3. **Start the development server**

   ```sh
   npm run dev
   ```

4. **Open your browser**
   ```
   Navigate to http://localhost:5173
   ```

---

## 🛠️ Available Scripts

### Development

```sh
npm run dev
```

Starts the Vite development server with hot module replacement.

### Build

```sh
npm run build
```

Type-checks the project and creates an optimized production build.

### Preview

```sh
npm run preview
```

Preview the production build locally.

### Testing

```sh
npm run test:unit
```

Run unit tests with [Vitest](https://vitest.dev/).

### Linting

```sh
npm run lint
```

Lint and fix code with [ESLint](https://eslint.org/).

### Type Checking

```sh
npm run type-check
```

Run TypeScript type checking without emitting files.

---

## 🏗️ Tech Stack

### Frontend

- **[Vue.js 3](https://vuejs.org/)** - Progressive JavaScript framework
- **[TypeScript](https://www.typescriptlang.org/)** - Type-safe JavaScript
- **[Vite](https://vitejs.dev/)** - Next-generation frontend tooling
- **[Vue Router](https://router.vuejs.org/)** - Official router for Vue.js
- **[Pinia](https://pinia.vuejs.org/)** - State management for Vue
- **[Tailwind CSS](https://tailwindcss.com/)** - Utility-first CSS framework
- **[Axios](https://axios-http.com/)** - HTTP client
- **[VueUse](https://vueuse.org/)** - Collection of Vue composition utilities

### Backend

- **PHP** - Server-side scripting
- **MySQL** - Database management

### Build Tools

- **[Vite](https://vitejs.dev/)** - Build tool and dev server
- **[ESLint](https://eslint.org/)** - Code linting
- **[Vitest](https://vitest.dev/)** - Unit testing framework
- **[TypeScript](https://www.typescriptlang.org/)** - Type checking

---

## 📁 Project Structure

```
control-center-cloud/
├── backend/                # PHP backend files
│   ├── files.php          # File operations API
│   ├── users.php          # User authentication API
│   └── classes/           # PHP classes (DB, FileManager, User)
├── src/
│   ├── assets/            # Static assets (images, styles)
│   ├── components/        # Vue components
│   │   ├── AppHeader.vue
│   │   ├── AppSidebar.vue
│   │   ├── FileManager.vue
│   │   └── FilePreviewModal.vue
│   ├── router/            # Vue Router configuration
│   ├── services/          # API services
│   ├── stores/            # Pinia stores
│   ├── types/             # TypeScript type definitions
│   ├── utils/             # Utility functions
│   ├── views/             # Page components
│   │   ├── FilesView.vue
│   │   ├── RecentView.vue
│   │   ├── SharedView.vue
│   │   ├── StarredView.vue
│   │   └── TrashView.vue
│   ├── App.vue            # Root component
│   └── main.ts            # Application entry point
├── public/                # Public static files
├── docs/                  # Documentation
├── package.json           # Project dependencies
├── vite.config.ts         # Vite configuration
├── tsconfig.json          # TypeScript configuration
└── tailwind.config.js     # Tailwind CSS configuration
```

---

## 💻 Development Setup

### Recommended IDE

[Visual Studio Code](https://code.visualstudio.com/) with the following extensions:

- **[Vue - Official](https://marketplace.visualstudio.com/items?itemName=Vue.volar)** - Vue language support
  - ⚠️ Disable Vetur if installed
- **[TypeScript Vue Plugin (Volar)](https://marketplace.visualstudio.com/items?itemName=Vue.vscode-typescript-vue-plugin)** - TypeScript support for `.vue` files
- **[ESLint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint)** - Code linting
- **[Tailwind CSS IntelliSense](https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss)** - Tailwind class suggestions

### Browser DevTools

#### Chromium-based browsers (Chrome, Edge, Brave)

- [Vue.js devtools](https://chromewebstore.google.com/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd)
- [Enable Custom Object Formatters](http://bit.ly/object-formatters) in DevTools settings

#### Firefox

- [Vue.js devtools](https://addons.mozilla.org/en-US/firefox/addon/vue-js-devtools/)
- [Enable Custom Object Formatters](https://fxdx.dev/firefox-devtools-custom-object-formatters/)

### Type Support for `.vue` Files

TypeScript doesn't natively understand `.vue` imports. This project uses:

- **`vue-tsc`** instead of `tsc` for type checking
- **[Volar](https://marketplace.visualstudio.com/items?itemName=Vue.volar)** for Vue 3 `.vue` file type support in your editor

---

## 🎯 Key Features Explained

### Multi-Drive System

Each user can create up to 3 independent drives, allowing for better organization:

- **Personal** - For personal files
- **Work** - For professional documents
- **Projects** - For project-specific content

### Smart File Filtering

Advanced filtering options help you find files quickly:

- **Type** - Filter by file type (folders, PDFs, images, videos, documents, etc.)
- **People** - Filter by file owner
- **Modified** - Filter by modification date (today, last 7 days, last 30 days, this year)
- **Source** - Filter between your files and files shared with you

### Bulk Operations

Select multiple files with checkboxes to perform batch operations:

- **Download** - Download all selected files
- **Star** - Add all selected files to starred
- **Delete** - Move all selected files to trash

---

## 🔧 Configuration

### Vite Configuration

See [Vite Configuration Reference](https://vite.dev/config/) for customization options.

### Environment Variables

Create a `.env` file in the root directory:

```env
VITE_API_BASE_URL=https://your-api-url.com
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## 👨‍💻 Author

**Alex Polan**

- GitHub: [@alexmen656](https://github.com/alexmen656)

---

## 🙏 Acknowledgments

- UI/UX inspired by [Google Drive](https://drive.google.com/)
- Built with [Vue.js 3](https://vuejs.org/) and modern web technologies
- Icons from [Heroicons](https://heroicons.com/)

---

<div align="center">

**Made with ❤️ and Vue.js**

</div>
