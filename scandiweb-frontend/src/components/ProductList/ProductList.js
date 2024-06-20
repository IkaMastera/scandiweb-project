import React from "react";
import { gql, useQuery } from "@apollo/client";
import ProductCard from "../ProductCard/ProductCard";
import "./ProductList.css";

const GET_PRODUCTS = gql`
  query GetProducts {
    products {
      id
      name
      category_id
      description
      in_stock
      brand
      gallery
      prices {
        amount
        currency_label
        currency_symbol
      }
    }
  }
`;

const ProductList = () => {
  const { loading, error, data } = useQuery(GET_PRODUCTS);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error: {error.message}</p>;

  return (
    <div className="product-list">
      {data.products.map((product) => (
        <ProductCard
          key={product.id}
          product={product}
          addToCart={(product) => console.log("Add to cart:", product)}
        />
      ))}
    </div>
  );
};

export default ProductList;
