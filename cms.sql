-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2019 at 10:58 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `date` varchar(200) NOT NULL,
  `addedby` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `date`, `addedby`) VALUES
(14, 'java', '1571997481', 'moonraj@19'),
(15, 'android development', '1571997481', 'farhana@idb'),
(16, 'Networking', '1571997481', 'dewan@nao'),
(17, 'HTML-5', '1571997481', 'kapilmath08'),
(18, 'Spring', '1571997481', 'moonraj@19'),
(19, 'JavaScript', '1571997481', 'moonraj@19'),
(20, 'Node JS', '1571997481', 'kapilmath08'),
(23, 'PHP', '1571997481', 'mezbamath08'),
(34, 'css3', '1572010774', 'ruhulmath08');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `date` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `post_id` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `comment` varchar(4000) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `date`, `name`, `username`, `post_id`, `email`, `website`, `image`, `comment`, `status`) VALUES
(51, 1572324857, 'Moon', 'user', 16, 'moon@gmail.com', 'http://www.moon.com', 'jannat.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'approve'),
(52, 1572325017, 'ruhul', 'user', 16, 'ruhul@gmail.com', 'http://www.ruhul.com', 'jannat.jpg', 'It says \'may\' rather than \'should\', but the information is there (below the table): There are several ways to include quote characters within a string: A â€œ\'â€ inside a string quoted with â€œ\'â€ may be written as â€œ\'\'â€. A â€œ\"â€ inside a string quoted with â€œ\"â€ may be written as â€œ\"\"â€. Precede the quote character by an escape character.', 'approve'),
(53, 1572325070, 'Shamim', 'user', 16, 'shamim@gamil.com', 'http://www.shamim.com', 'jannat.jpg', 'but this is creating error due to \'s means it creating problem because of single quote \' .\r\n\r\nplease suggest me how can i handle this. currently i am right this directly St. Josed father\'s institute but in my php code this is in variable $university_name\r\n\r\nso please suggest me how can i check and remove such type of problem.', 'approve'),
(54, 1572670288, 'Moon', 'user', 32, 'moon@gmail.com', 'http://www.moon.com', 'jannat.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `datetime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `image`, `author`, `datetime`) VALUES
(39, 'add_fresh_75514_1572252787.gif', 'ruhulmath08', '1572252787'),
(40, 'api_85203_1572252787.png', 'ruhulmath08', '1572252787'),
(41, 'C-Programming_65364_1572252787.jpg', 'ruhulmath08', '1572252787'),
(42, 'html5_74521_1572252787.jpg', 'ruhulmath08', '1572252787'),
(43, 'java_jar-on-windows-10_74074_1572252787.png', 'ruhulmath08', '1572252787'),
(44, 'Java-8_15325_1572252787.jpg', 'ruhulmath08', '1572252787'),
(45, 'Java-logo-png_67552_1572252787.png', 'ruhulmath08', '1572252787'),
(46, 'layer_chocklet_87921_1572252787.gif', 'ruhulmath08', '1572252787'),
(47, 'linux_66558_1572252787.jpg', 'ruhulmath08', '1572252787'),
(48, 'networking_65396_1572252787.jpg', 'ruhulmath08', '1572252787'),
(49, 'nodejs_91782_1572252787.jpeg', 'ruhulmath08', '1572252787'),
(50, 'spring_16517_1572252787.png', 'ruhulmath08', '1572252787'),
(51, 'spring-framework_33643_1572252787.png', 'ruhulmath08', '1572252787'),
(52, 'james_gosling_24753_1572256016.jpg', 'ruhulmath08', '1572256016'),
(53, 'php_app_flowchart_92453_1572414445.jpg', 'ruhulmath08', '1572414445');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `author_image` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `post_data` text NOT NULL,
  `views` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `date`, `title`, `author`, `author_image`, `image`, `categories`, `tags`, `post_data`, `views`, `status`) VALUES
(32, 1572678531, 'History of Java language and the about it\'s creator.', 'ruhulmath08', 'ruhul_amin_61849_1571561153.png', 'spring_28174_1572678531.png', 'java', 'java, core java, java se, java ee, games gosling', '<p>What is Java:</p>\r\n<p>Java is a general-purpose programming language that is class-based, object-oriented, and designed to have as few implementation dependencies as possible. It is intended to let application developers write once, run anywhere (WORA),[15] meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.[16] Java applications are typically compiled to bytecode that can run on any Java virtual machine (JVM) regardless of the underlying computer architecture. The syntax of Java is similar to C and C++, but it has fewer low-level facilities than either of them. As of 2019, Java was one of the most popular programming languages in use according to GitHub,[17][18] particularly for client-server web applications, with a reported 9 million developers.</p>\r\n<p style=\"text-align: center;\"><img src=\"uploads/media/Java-8_15325_1572252787.jpg\" alt=\"Java-8_15325_1572252787.jpg\" width=\"677\" height=\"376\" /></p>\r\n<p>Father of Java:</p>\r\n<p>Java was originally developed by James Gosling at Sun Microsystems (which has since been acquired by Oracle) and released in 1995 as a core component of Sun Microsystems\' Java platform. The original and reference implementation Java compilers, virtual machines, and class libraries were originally released by Sun under proprietary licenses. As of May 2007, in compliance with the specifications of the Java Community Process, Sun had relicensed most of its Java technologies under the GNU General Public License. Meanwhile, others have developed alternative implementations of these Sun technologies, such as the GNU Compiler for Java (bytecode compiler), GNU Classpath (standard libraries), and IcedTea-Web (browser plugin for applets).</p>\r\n<p>Latest Version:</p>\r\n<p>The latest versions are Java 13, released in September 2019, and Java 11, a currently supported long-term support (LTS) version, released on September 25, 2018; Oracle released for the legacy Java 8 LTS the last free public update in January 2019 for commercial use, while it will otherwise still support Java 8 with public updates for personal use up to at least December 2020. Oracle (and others) highly recommend uninstalling older versions of Java because of serious risks due to unresolved security issues.[20] Since Java 9 (and 10 and 12) is no longer supported, Oracle advises its users to immediately transition to Java 11 (Java 13 is also a non-LTS option).</p>\r\n<p>About the Crearor of Java:</p>\r\n<p>James Gosling, Mike Sheridan, and Patrick Naughton initiated the Java language project in June 1991.[21] Java was originally designed for interactive television, but it was too advanced for the digital cable television industry at the time.[22] The language was initially called Oak after an oak tree that stood outside Gosling\'s office. Later the project went by the name Green and was finally renamed Java, from Java coffee.[23] Gosling designed Java with a C/C++-style syntax that system and application programmers would find familiar.[24]</p>\r\n<p>Sun Microsystems released the first public implementation as Java 1.0 in 1996.[25] It promised Write Once, Run Anywhere (WORA), providing no-cost run-times on popular platforms. Fairly secure and featuring configurable security, it allowed network- and file-access restrictions. Major web browsers soon incorporated the ability to run Java applets within web pages, and Java quickly became popular. The Java 1.0 compiler was re-written in Java by Arthur van Hoff to comply strictly with the Java 1.0 language specification.[26] With the advent of Java 2 (released initially as J2SE 1.2 in December 1998 &ndash; 1999), new versions had multiple configurations built for different types of platforms. J2EE included technologies and APIs for enterprise applications typically run in server environments, while J2ME featured APIs optimized for mobile applications. The desktop version was renamed J2SE. In 2006, for marketing purposes, Sun renamed new J2 versions as Java EE, Java ME, and Java SE, respectively.</p>\r\n<p>In 1997, Sun Microsystems approached the ISO/IEC JTC 1 standards body and later the Ecma International to formalize Java, but it soon withdrew from the process.[27][28][29] Java remains a de facto standard, controlled through the Java Community Process.[30] At one time, Sun made most of its Java implementations available without charge, despite their proprietary software status. Sun generated revenue from Java through the selling of licenses for specialized products such as the Java Enterprise System.</p>\r\n<p><span style=\"text-decoration: underline;\"><strong>Java Code</strong></span>:</p>\r\n<pre class=\"language-java\"><code>package com.controller;\r\n\r\nimport java.util.List;\r\n\r\nimport org.springframework.beans.factory.annotation.Autowired;\r\nimport org.springframework.http.HttpStatus;\r\nimport org.springframework.security.core.context.SecurityContextHolder;\r\nimport org.springframework.security.core.userdetails.User;\r\nimport org.springframework.stereotype.Controller;\r\nimport org.springframework.web.bind.annotation.PathVariable;\r\nimport org.springframework.web.bind.annotation.RequestMapping;\r\nimport org.springframework.web.bind.annotation.ResponseStatus;\r\n\r\nimport com.model.Cart;\r\nimport com.model.CartItem;\r\nimport com.model.Customer;\r\nimport com.model.Product;\r\nimport com.service.CartItemService;\r\nimport com.service.CartService;\r\nimport com.service.CustomerService;\r\nimport com.service.ProductService;\r\n\r\n@Controller\r\npublic class CartItemController {\r\n\r\n	@Autowired\r\n	private CartService cartService;\r\n\r\n	@Autowired\r\n	private CartItemService cartItemService;\r\n\r\n	@Autowired\r\n	private CustomerService customerService;\r\n\r\n	@Autowired\r\n	private ProductService productService;\r\n\r\n	\r\n	public CustomerService getCustomerService() {\r\n		return customerService;\r\n	}\r\n\r\n	public void setCustomerService(CustomerService customerService) {\r\n		this.customerService = customerService;\r\n	}\r\n\r\n	public ProductService getProductService() {\r\n		return productService;\r\n	}\r\n\r\n	public void setProductService(ProductService productService) {\r\n		this.productService = productService;\r\n	}\r\n\r\n	public CartService getCartService() {\r\n		return cartService;\r\n	}\r\n\r\n	public void setCartService(CartService cartService) {\r\n		this.cartService = cartService;\r\n	}\r\n\r\n	public CartItemService getCartItemService() {\r\n		return cartItemService;\r\n	}\r\n\r\n	public void setCartItemService(CartItemService cartItemService) {\r\n		this.cartItemService = cartItemService;\r\n	}\r\n\r\n	@RequestMapping(\"/cart/add/{productId}\")\r\n	@ResponseStatus(value = HttpStatus.NO_CONTENT)\r\n	public void addCartItem(@PathVariable(value = \"productId\") String productId) {\r\n		User user = (User) SecurityContextHolder.getContext().getAuthentication().getPrincipal();\r\n		String emailId = user.getUsername();\r\n		Customer customer = customerService.getCustomerByemailId(emailId);\r\n		System.out.println(\"Customer : \" + customer.getUsers().getEmailId());\r\n		Cart cart = customer.getCart();\r\n		System.out.println(cart);\r\n		List&lt;CartItem&gt; cartItems = cart.getCartItem();\r\n		Product product = productService.getProductById(productId);\r\n		for (int i = 0; i &lt; cartItems.size(); i++) {\r\n			CartItem cartItem = cartItems.get(i);\r\n			if (product.getProductId().equals(cartItem.getProduct().getProductId())) {\r\n				cartItem.setQuality(cartItem.getQuality() + 1);\r\n				cartItem.setPrice(cartItem.getQuality() * cartItem.getProduct().getProductPrice());\r\n				cartItemService.addCartItem(cartItem);\r\n				return;\r\n			}\r\n		}\r\n		CartItem cartItem = new CartItem();\r\n		cartItem.setQuality(1);\r\n		cartItem.setProduct(product);\r\n		cartItem.setPrice(product.getProductPrice() * 1);\r\n		cartItem.setCart(cart);\r\n		cartItemService.addCartItem(cartItem);\r\n	}\r\n\r\n	@RequestMapping(\"/cart/removeCartItem/{cartItemId}\")\r\n	@ResponseStatus(value = HttpStatus.NO_CONTENT)\r\n	public void removeCartItem(@PathVariable(value = \"cartItemId\") String cartItemId) {\r\n		cartItemService.removeCartItem(cartItemId);\r\n	}\r\n\r\n	@RequestMapping(\"/cart/removeAllItems/{cartId}\")\r\n	@ResponseStatus(value = HttpStatus.NO_CONTENT)\r\n	public void removeAllCartItems(@PathVariable(value = \"cartId\") String cartId) {\r\n		Cart cart = cartService.getCartByCartId(cartId);\r\n		cartItemService.removeAllCartItems(cart);\r\n	}\r\n}</code></pre>', 10, 'publish');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `date` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `salt` varchar(255) NOT NULL DEFAULT '$2y$10$qerckbmproxownfjuiusov'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`, `details`, `salt`) VALUES
(62, 1571560578, 'Dewan', 'Jannat', 'dewan@nao', 'dewan@gmail.com', 'dewan_84633_1572673352.jpg', '$2y$10$qerckbmproxownfjuiusouROwrbQ18sBpCga6Gt/.X042RpAMTJH2', 'author', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(63, 1571560634, 'Farhana', 'Pervin', 'farhana@idb', 'farhama@gmail.com', 'farhana_27886_1571560634.jpg', '$2y$10$qerckbmproxownfjuiusouXQ.eiFBJGEfXZSvz2lLSXuDyuN/CrI6', 'author', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(64, 1571560667, 'Kapil', 'Dev', 'kapilmath08', 'kapilmath@gmail.com', 'kapil_61733_1571560667.png', '$2y$10$qerckbmproxownfjuiusouo4AFckgFZIXQuPCAomxbqs1uaNP5KuS', 'admin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(65, 1571560896, 'Mezabul', 'Islam', 'mezbamath08', 'mezbamath08@gmail.com', 'mezba_23095_1571560896.png', '$2y$10$qerckbmproxownfjuiusou/YT6VIBFVbpPKK86QCsJqrJduyOXHwS', 'admin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(66, 1571561064, 'Nusrat', 'Akbor', 'moonraj@19', 'moonraj19@gmail.com', 'moon_85915_1571561064.jpg', '$2y$10$qerckbmproxownfjuiusouCXk6Nr1wdvQO1sYlm6EchrlklmOmVHK', 'admin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(67, 1571561109, 'Rezaul', 'Karim', 'rezamath08', 'rezamath08@gmail.com', 'reza_17989_1571561109.png', '$2y$10$qerckbmproxownfjuiusou5fMWlVouFJlvM3DbaqsMTSbceUUCqDC', 'admin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov'),
(68, 1571561153, 'Md. Ruhul', 'Amin', 'ruhulmath08', 'ruhulodduu@gmail.com', 'ruhul_amin_61849_1571561153.png', '$2y$10$qerckbmproxownfjuiusou22N1vOUv9uzow.Nk8WDbCHu7Q34Hcsy', 'admin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '$2y$10$qerckbmproxownfjuiusov');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
