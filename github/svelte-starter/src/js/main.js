import HW from '../components/hello.html';

const component = new HW({
  target: document.querySelector( 'main' ),
  data: {
      name: "World"
  }
});
