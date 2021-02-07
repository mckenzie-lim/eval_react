import React, { Component } from 'react';
import { Navbar, NavbarBrand, Nav, NavLink } from 'react-bootstrap';
import {Link} from 'react-router-dom'; 

class Header extends Component {
    render() {
        return (
            <div>
                <Navbar bg="dark" variant="dark">
                    <Navbar.Brand href="#home">Navbar</Navbar.Brand>
                    <Nav className="mr-auto">
                        <Link to='/'>Home</Link>&nbsp;&nbsp;&nbsp;&nbsp;
                        <Link to='/teachers'>Teachers</Link>&nbsp;&nbsp;&nbsp;&nbsp;
                    </Nav>
                </Navbar>
            </div>
        );
    }
}

export { Header };