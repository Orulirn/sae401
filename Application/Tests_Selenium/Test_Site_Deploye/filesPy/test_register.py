# Generated by Selenium IDE
import pytest
import time
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class TestRegister():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_register(self):
    self.driver.get("http://4.234.188.41/Controller/Accueil/HomePageController.php")
    self.driver.set_window_size(1528, 820)
    self.driver.find_element(By.ID, "Inscription").click()
    self.driver.find_element(By.ID, "firstname").click()
    self.driver.find_element(By.ID, "firstname").send_keys("Corentin")
    self.driver.find_element(By.ID, "lastname").click()
    self.driver.find_element(By.ID, "lastname").send_keys("Gauquier")
    self.driver.find_element(By.ID, "mail").click()
    self.driver.find_element(By.ID, "mail").send_keys("cgauquier@gmail.com")
    self.driver.find_element(By.ID, "password").click()
    self.driver.find_element(By.ID, "password").send_keys("Bbbbbbb-6")
    self.driver.find_element(By.ID, "verif").click()
    self.driver.find_element(By.ID, "verif").send_keys("Bbbbbbb-6")
    self.driver.find_element(By.ID, "register").click()
    self.driver.close()
  
