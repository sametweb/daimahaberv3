## daimahaberv3 Template Features
- Full Responsive
- First Mobile
- Dark Mode
- 100% Widget Support
- (Optional) Sticky Header
- HTML/CSS Valid

## Project Status
- [x] Template responsiveness
- [x] Homepage component(s) (index.php)
- [ ] Single page component(s) (single.php)
- [ ] Category page component(s) (category.php)
- [ ] Image gallery component(s) (gallery.php)

## How to contribute?

Although it is a WordPress template, you may work on HTML/CSS part of each component and disregard the WordPress integration.

0. Fork this repo
1. Create a `.less` file in `less` directory with the file name you are working with (i.e. category.less)
2. Add your file in `index.less` imports (i.e. `@import "category";`)
3. Install `less` by `npm install -g less`
4. Install [`watch-less-compiler`](https://www.npmjs.com/package/less-watch-compiler) by `npm install -g watch-less-compiler`
5. Go to project folder in your terminal and run the command:
```less-watch-compiler less css index.less```
This way, every change you make in your `.less` file will be compiled into the main `index.css` file
6. Make sure your designs look same on major browsers: Chrome, Firefox, Opera, Microsoft Edge
7. Submit a pull request
