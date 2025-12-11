// @ts-check
// `@type` JSDoc annotations allow editor autocompletion and type checking
// (when paired with `@ts-check`).
// There are various equivalent ways to declare your Docusaurus config.
// See: https://docusaurus.io/docs/api/docusaurus-config

import {themes as prismThemes} from 'prism-react-renderer';

/** @type {import('@docusaurus/types').Config} */
const config = {
    title: 'LmcCors',
    tagline: 'LmcCors is a simple Laminas MVC module that helps you to deal with Cross-Origin Resource Sharing (CORS).',
    favicon: 'img/favicon.ico',

  // Set the production url of your site here
    url: 'https://lm-commons.github.io',
  // Set the /<baseUrl>/ pathname under which your site is served
  // For GitHub pages deployment, it is often '/<projectName>/'
    baseUrl: '/LmcCors/',

  // GitHub pages deployment config.
  // If you aren't using GitHub pages, you don't need these.
    organizationName: 'lm-commons', // Usually your GitHub org/user name.
    projectName: 'LmcCors', // Usually your repo name.
    trailingSlash: false,

    onBrokenLinks: 'throw',

  // Even if you don't use internationalization, you can use this field to set
  // useful metadata like html lang. For example, if your site is Chinese, you
  // may want to replace "en" with "zh-Hans".
    i18n: {
        defaultLocale: 'en',
        locales: ['en'],
    },

    markdown: {
        hooks: {
            onBrokenMarkdownLinks: 'warn',
        }
    },

    presets: [
    [
      'classic',
      /** @type {import('@docusaurus/preset-classic').Options} */
      ({
            docs: {
                sidebarPath: './sidebars.js',
              // Please change this to your repo.
              // Remove this to remove the "edit this page" links.
                editUrl:
                'https://github.com/lm-commons/lmccors/tree/master/docs/',
            },
            blog: {
                showReadingTime: true,
              // Please change this to your repo.
              // Remove this to remove the "edit this page" links.
                editUrl:
                'https://github.com/lm-commons/lmccors/tree/master/docs/',
                onUntruncatedBlogPosts: 'ignore'
            },
            theme: {
                customCss: './src/css/custom.css',
            },
            googleTagManager: {
              containerId: 'GTM-5PVZSCQ6'
            },
        }),
    ],
  ],

themeConfig:
    /** @type {import('@docusaurus/preset-classic').ThemeConfig} */
    ({
      // Replace with your project's social card
        image: 'img/LMC-social-card.png',

        announcementBar: {
            id: 'mvc-maintenance-only',
            content: "<h1 style='font-size: 120%'><strong>LmcCors is now Maintenance-only. <a href='https://lm-commons.github.io/blog/MVC-maintenance-only'>Details</a> </strong></h1>",
            isCloseable: false,
            backgroundColor: 'lightyellow'
        },

        navbar: {
            title: 'LmcCors',
            logo: {
                alt: 'LM-Commons Logo',
                src: 'img/LMC-logo.png',
            },
            items: [
            {
                type: 'docSidebar',
                sidebarId: 'tutorialSidebar',
                position: 'left',
                label: 'Documentation',
            },
                {
                    href: 'https://lm-commons.github.io',
                    label: 'LM-Commons',
                    position: 'right',
                },
            {
                href: 'https://github.com/lm-commons/lmccors',
//                label: 'GitHub',
                position: 'right',
                className: 'header-github-link',
            },
            ],
        },
        footer: {
            style: 'dark',
            links: [
            {
                title: 'Community',
                items: [
                {
                    label: 'Discord',
                    href: 'https://discord.gg/nAAu7AhR',
                },
                ],
            },
            {
                title: 'More',
                items: [
                {
                    label: 'GitHub',
                    href: 'https://github.com/lm-commons/lmccors',
                },
                ],
            },
            ],
            copyright: `Copyright © ${new Date().getFullYear()} LM-Commons Organization. Built with Docusaurus.`,
        },
        prism: {
            theme: prismThemes.github,
            darkTheme: prismThemes.dracula,
            additionalLanguages: ['bash', 'json', 'php']
        },
    }),
};

export default config;
