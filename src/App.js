import logo from './logo.svg';
import './App.css';
import { Component } from 'react';
import {BrowserRouter as Router} from 'react-router-dom'; 
import {Header, Main, Footer} from './Components'; 
import 'bootstrap/dist/css/bootstrap.min.css';


class App extends Component 
{

  render()
  {
    return (
      <>
      <Router>
        <header>
          <Header />
        </header>
        <main>
          <Main />
        </main>
        <footer>
          <Footer />
        </footer>
      </Router>
      </>
    )
  }

}

export {App};
