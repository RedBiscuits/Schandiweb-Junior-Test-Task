import * as Yup from "yup";


export function getYup(type , options){
    const productValidationSchema = Yup.object({
      name: Yup.string().max(255).required("Name is required"),
      sku: Yup.string().max(255).required("SKU is required"),
      price: Yup.number()
        .transform((value, originalValue) => {
          const newValue = originalValue.replace("$", "");
          return parseFloat(newValue);
        })
        .min(0)
        .required("Price is required"),
      selectedOption: Yup.string()
        .oneOf(options.map((option) => option.value))
        .required("Type is required"),
      size: Yup.string().required("DVD field is required"), // add size field to the root schema
    });
    
    const actions = {
      dvd: () =>
        Yup.object().shape({
          // create a new schema object with merged rules
          size: Yup.string().required("DVD field is required"),
        }),
      book: () =>Yup.object().shape({
        // create a new schema object with merged rules
        weight: Yup.string().required("Book field is required"),
      }),
      furniture: ()=>Yup.object().shape({
        // create a new schema object with merged rules
        length: Yup.string()
        .required("Length field is required"),
        width:Yup.string().required("Width field is required"),
        height: Yup.string().required("Height field is required")
            }), 
    };
    
  actions[type]()
  return productValidationSchema;
  }