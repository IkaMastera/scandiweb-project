import React from "react";
import "./Header.css";
import emptyCart from "../../images/emptycart.svg";
import logo from "../../images/a-logo.svg";

const Header = ({ cartItems }) => {
  return (
    <header className="header">
      <nav className="nav">
        <ul className="nav-list">
          <li className="nav-item">Women</li>
          <li className="nav-item">Men</li>
          <li className="nav-item">Kids</li>
        </ul>
      </nav>
      <img src={logo} alt="website logo" />
      <div className="cart">
        <img src={emptyCart} alt="empty cart logo" />
      </div>
    </header>
  );
};

export default Header;
