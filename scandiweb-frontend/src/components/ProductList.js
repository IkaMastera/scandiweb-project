import React from "react";
import { gql, useQuery } from "@apollo/client";

const GET_PRODUCTS = gql`
  query GetProducts {
    products {
      id
      name
      category_id
      description
      in_stock
      brand
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
    <div>
      {data.products.map((product) => (
        <div key={product.id}>
          <h2>{product.name}</h2>
          <p>{product.description}</p>
          <p>{product.in_stock ? "In Stock" : "Out of Stock"}</p>
          <p>Brand: {product.brand}</p>
          <div>
            {product.prices.map((price, index) => (
              <p key={index}>
                {price.currency_symbol}
                {price.amount} {price.currency_label}
              </p>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
};

export default ProductList;
